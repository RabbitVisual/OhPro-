<?php

namespace Modules\Billing\Services;

use App\Contracts\Billing\SubscriptionGatewayInterface;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;
use Stripe\Webhook;

class StripeSubscriptionGateway implements SubscriptionGatewayInterface
{
    public function __construct(
        protected StripeClient $stripe
    ) {}

    public function gatewayName(): string
    {
        return 'stripe';
    }

    public function createCheckoutSession(User $user, Plan $plan, string $interval, string $successUrl, string $cancelUrl): string
    {
        if ($plan->isFree()) {
            throw new \InvalidArgumentException('Cannot create checkout for free plan.');
        }

        $priceId = $interval === 'year' && $plan->stripe_price_yearly_id
            ? $plan->stripe_price_yearly_id
            : $plan->stripe_price_id;

        if (! $priceId) {
            throw new \InvalidArgumentException('Stripe Price ID not configured for this plan/interval.');
        }

        $customerId = $this->getOrCreateCustomerId($user);

        $session = $this->stripe->checkout->sessions->create([
            'customer' => $customerId,
            'mode' => 'subscription',
            'line_items' => [
                [
                    'price' => $priceId,
                    'quantity' => 1,
                ],
            ],
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'user_id' => (string) $user->id,
                'plan_id' => (string) $plan->id,
                'interval' => $interval,
            ],
            'subscription_data' => [
                'metadata' => [
                    'user_id' => (string) $user->id,
                    'plan_id' => (string) $plan->id,
                ],
            ],
        ]);

        return $session->url;
    }

    public function cancelSubscription(Subscription $subscription): bool
    {
        if ($subscription->gateway !== 'stripe' || ! $subscription->gateway_subscription_id) {
            return false;
        }
        try {
            $this->stripe->subscriptions->update($subscription->gateway_subscription_id, ['cancel_at_period_end' => true]);
            $subscription->update(['canceled_at' => $subscription->current_period_end]);
            return true;
        } catch (\Throwable $e) {
            Log::warning('Stripe cancel subscription failed', ['subscription_id' => $subscription->id, 'error' => $e->getMessage()]);
            return false;
        }
    }

    public function syncSubscriptionFromWebhook(array $payload): ?Subscription
    {
        $eventId = $payload['id'] ?? null;
        if (! $eventId) {
            return null;
        }
        if ($this->eventAlreadyProcessed($eventId)) {
            return null;
        }

        $type = $payload['type'] ?? '';
        $data = $payload['data']['object'] ?? [];
        $result = null;

        if ($type === 'checkout.session.completed') {
            $result = $this->handleCheckoutSessionCompleted($data);
        } elseif (in_array($type, ['customer.subscription.created', 'customer.subscription.updated', 'customer.subscription.deleted'], true)) {
            $result = $this->handleSubscriptionEvent($type, $data);
        }

        $this->markEventProcessed($eventId, $type);
        return $result;
    }

    protected function getOrCreateCustomerId(User $user): string
    {
        $existing = Subscription::where('user_id', $user->id)->where('gateway', 'stripe')->whereNotNull('gateway_customer_id')->first();
        if ($existing?->gateway_customer_id) {
            return $existing->gateway_customer_id;
        }

        $customer = $this->stripe->customers->create([
            'email' => $user->email,
            'name' => $user->full_name,
            'metadata' => ['user_id' => (string) $user->id],
        ]);
        return $customer->id;
    }

    protected function handleCheckoutSessionCompleted(array $session): ?Subscription
    {
        $subId = $session['subscription'] ?? null;
        if (! $subId) {
            return null;
        }
        $stripeSub = $this->stripe->subscriptions->retrieve($subId, ['expand' => ['default_payment_method']]);
        $arr = method_exists($stripeSub, 'toArray') ? $stripeSub->toArray() : json_decode(json_encode($stripeSub), true);
        return $this->upsertSubscriptionFromStripe($arr);
    }

    protected function handleSubscriptionEvent(string $type, array $data): ?Subscription
    {
        if ($type === 'customer.subscription.deleted') {
            $sub = Subscription::where('gateway', 'stripe')->where('gateway_subscription_id', $data['id'])->first();
            if ($sub) {
                $sub->update(['status' => 'canceled', 'canceled_at' => now()]);
                $sub->user->update(['membership' => 'free']);
            }
            return $sub;
        }
        return $this->upsertSubscriptionFromStripe($data);
    }

    protected function upsertSubscriptionFromStripe(array $stripeSub): ?Subscription
    {
        $planId = (int) ($stripeSub['metadata']['plan_id'] ?? 0);
        $userId = (int) ($stripeSub['metadata']['user_id'] ?? 0);
        if (! $planId || ! $userId) {
            return null;
        }

        $status = match ($stripeSub['status'] ?? '') {
            'active', 'trialing' => $stripeSub['status'],
            'canceled', 'unpaid', 'incomplete_expired' => 'canceled',
            'past_due' => 'past_due',
            default => 'incomplete',
        };

        $plan = Plan::find($planId);
        $membership = $plan ? ($plan->key === 'pro_annual' ? 'pro_annual' : 'pro') : 'free';

        $subscription = Subscription::updateOrCreate(
            [
                'gateway' => 'stripe',
                'gateway_subscription_id' => $stripeSub['id'],
            ],
            [
                'user_id' => $userId,
                'plan_id' => $planId,
                'gateway_customer_id' => $stripeSub['customer'] ?? null,
                'status' => $status,
                'current_period_start' => isset($stripeSub['current_period_start']) ? \Carbon\Carbon::createFromTimestamp($stripeSub['current_period_start']) : null,
                'current_period_end' => isset($stripeSub['current_period_end']) ? \Carbon\Carbon::createFromTimestamp($stripeSub['current_period_end']) : null,
                'canceled_at' => $status === 'canceled' ? now() : null,
                'metadata' => $stripeSub,
            ]
        );

        if (in_array($status, ['active', 'trialing'], true)) {
            $subscription->user->update(['membership' => $membership]);
        }

        return $subscription;
    }

    protected function eventAlreadyProcessed(string $eventId): bool
    {
        return DB::table('webhook_events')->where('gateway', 'stripe')->where('event_id', $eventId)->exists();
    }

    protected function markEventProcessed(string $eventId, ?string $type = null): void
    {
        DB::table('webhook_events')->insert([
            'gateway' => 'stripe',
            'event_id' => $eventId,
            'type' => $type,
            'processed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /** Verify webhook signature and return payload array or null. */
    public static function verifyWebhook(string $payload, string $signature): ?array
    {
        $secret = config('services.stripe.webhook_secret');
        if (! $secret) {
            return null;
        }
        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
            return json_decode(json_encode($event), true);
        } catch (\Throwable $e) {
            Log::warning('Stripe webhook signature verification failed', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
