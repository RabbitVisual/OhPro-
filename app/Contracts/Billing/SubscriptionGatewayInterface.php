<?php

namespace App\Contracts\Billing;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;

interface SubscriptionGatewayInterface
{
    /**
     * Create a checkout session (Stripe) or preference (Mercado Pago) for a new subscription.
     * Returns the URL to redirect the user to.
     */
    public function createCheckoutSession(User $user, Plan $plan, string $interval, string $successUrl, string $cancelUrl): string;

    /**
     * Cancel a subscription at the gateway.
     */
    public function cancelSubscription(Subscription $subscription): bool;

    /**
     * Sync subscription state from a webhook payload. Returns the updated or created Subscription model.
     */
    public function syncSubscriptionFromWebhook(array $payload): ?Subscription;

    /**
     * Return the gateway name (e.g. 'stripe', 'mercadopago').
     */
    public function gatewayName(): string;
}
