<?php

namespace Modules\Billing\Services;

use App\Contracts\Billing\SubscriptionGatewayInterface;
use App\Models\Plan;
use App\Models\User;
use Stripe\StripeClient;

class BillingService
{
    public function gateway(?string $name = null): SubscriptionGatewayInterface
    {
        $name = $name ?? config('billing.default_gateway', 'stripe');
        return match ($name) {
            'stripe' => new StripeSubscriptionGateway(
                new StripeClient(config('services.stripe.secret'))
            ),
            'mercadopago' => app(MercadoPagoSubscriptionGateway::class),
            default => throw new \InvalidArgumentException("Unknown gateway: {$name}"),
        };
    }

    public function createCheckout(User $user, Plan $plan, string $interval, string $gateway = null): string
    {
        $successUrl = route('billing.success');
        $cancelUrl = route('billing.cancel');
        return $this->gateway($gateway)->createCheckoutSession($user, $plan, $interval, $successUrl, $cancelUrl);
    }
}
