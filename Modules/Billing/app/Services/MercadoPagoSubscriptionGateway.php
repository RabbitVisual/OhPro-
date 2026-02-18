<?php

namespace Modules\Billing\Services;

use App\Contracts\Billing\SubscriptionGatewayInterface;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MercadoPagoSubscriptionGateway implements SubscriptionGatewayInterface
{
    protected string $accessToken;

    public function __construct()
    {
        $this->accessToken = config('services.mercadopago.access_token', '');
    }

    public function gatewayName(): string
    {
        return 'mercadopago';
    }

    public function createCheckoutSession(User $user, Plan $plan, string $interval, string $successUrl, string $cancelUrl): string
    {
        if ($plan->isFree()) {
            throw new \InvalidArgumentException('Cannot create checkout for free plan.');
        }

        $amount = $interval === 'year' && $plan->price_yearly
            ? (float) $plan->price_yearly
            : (float) $plan->price_monthly;
        $frequency = $interval === 'year' ? 12 : 1;
        $frequencyType = 'months';

        $payload = [
            'reason' => 'Oh Pro! - ' . $plan->name,
            'auto_recurring' => [
                'frequency' => $frequency,
                'frequency_type' => $frequencyType,
                'transaction_amount' => round($amount, 2),
                'currency_id' => 'BRL',
            ],
            'payer_email' => $user->email,
            'back_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'user_id' => (string) $user->id,
                'plan_id' => (string) $plan->id,
                'interval' => $interval,
            ],
            'status' => 'pending', // User completes payment; then we get webhook
        ];

        $response = Http::withToken($this->accessToken)
            ->post('https://api.mercadopago.com/preapproval', $payload);

        if (! $response->successful()) {
            Log::error('Mercado Pago preapproval failed', ['response' => $response->json(), 'status' => $response->status()]);
            throw new \RuntimeException('Não foi possível criar a assinatura. Tente novamente.');
        }

        $data = $response->json();
        $initPoint = $data['init_point'] ?? $data['sandbox_init_point'] ?? null;
        if (! $initPoint) {
            throw new \RuntimeException('Resposta inválida do gateway.');
        }
        return $initPoint;
    }

    public function cancelSubscription(Subscription $subscription): bool
    {
        if ($subscription->gateway !== 'mercadopago' || ! $subscription->gateway_subscription_id) {
            return false;
        }
        try {
            $response = Http::withToken($this->accessToken)
                ->put('https://api.mercadopago.com/preapproval/' . $subscription->gateway_subscription_id, ['status' => 'cancelled']);
            if ($response->successful()) {
                $subscription->update(['status' => 'canceled', 'canceled_at' => now()]);
                $subscription->user->update(['membership' => 'free']);
                return true;
            }
        } catch (\Throwable $e) {
            Log::warning('Mercado Pago cancel failed', ['subscription_id' => $subscription->id, 'error' => $e->getMessage()]);
        }
        return false;
    }

    public function syncSubscriptionFromWebhook(array $payload): ?Subscription
    {
        $id = $payload['id'] ?? $payload['data']['id'] ?? null;
        $type = $payload['type'] ?? $payload['action'] ?? '';
        if (! $id) {
            return null;
        }
        if ($this->eventAlreadyProcessed('mercadopago', $id . '_' . $type)) {
            return null;
        }

        // MP can send payment or preapproval notifications
        if (str_contains((string) $type, 'payment') || isset($payload['data']['id'])) {
            $preapprovalId = $payload['data']['id'] ?? $id;
            return $this->syncPreapproval($preapprovalId);
        }
        return $this->syncPreapproval($id);
    }

    protected function syncPreapproval(string $preapprovalId): ?Subscription
    {
        $response = Http::withToken($this->accessToken)
            ->get('https://api.mercadopago.com/preapproval/' . $preapprovalId);
        if (! $response->successful()) {
            return null;
        }
        $data = $response->json();
        $metadata = $data['metadata'] ?? [];
        $userId = (int) ($metadata['user_id'] ?? 0);
        $planId = (int) ($metadata['plan_id'] ?? 0);
        if (! $userId || ! $planId) {
            return null;
        }

        $status = match ($data['status'] ?? '') {
            'authorized', 'active' => 'active',
            'pending' => 'incomplete',
            'cancelled', 'expired' => 'canceled',
            'paused' => 'past_due',
            default => 'incomplete',
        };

        $plan = Plan::find($planId);
        $membership = $plan ? ($plan->key === 'pro_annual' ? 'pro_annual' : 'pro') : 'free';

        $subscription = Subscription::updateOrCreate(
            [
                'gateway' => 'mercadopago',
                'gateway_subscription_id' => $preapprovalId,
            ],
            [
                'user_id' => $userId,
                'plan_id' => $planId,
                'gateway_customer_id' => $data['payer_id'] ?? null,
                'status' => $status,
                'current_period_start' => isset($data['date_created']) ? \Carbon\Carbon::parse($data['date_created']) : null,
                'current_period_end' => isset($data['end_date']) ? \Carbon\Carbon::parse($data['end_date']) : null,
                'canceled_at' => $status === 'canceled' ? now() : null,
                'metadata' => $data,
            ]
        );

        if ($status === 'active') {
            $subscription->user->update(['membership' => $membership]);
        }

        $this->markEventProcessed('mercadopago', $preapprovalId . '_sync');
        return $subscription;
    }

    protected function eventAlreadyProcessed(string $gateway, string $eventId): bool
    {
        return DB::table('webhook_events')->where('gateway', $gateway)->where('event_id', $eventId)->exists();
    }

    protected function markEventProcessed(string $gateway, string $eventId): void
    {
        DB::table('webhook_events')->insert([
            'gateway' => $gateway,
            'event_id' => $eventId,
            'type' => null,
            'processed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
