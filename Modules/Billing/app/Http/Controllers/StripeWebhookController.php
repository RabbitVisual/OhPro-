<?php

namespace Modules\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Billing\Services\BillingService;
use Modules\Billing\Services\StripeSubscriptionGateway;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, BillingService $billing): Response
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature', '');

        $event = StripeSubscriptionGateway::verifyWebhook($payload, $signature);
        if (! $event) {
            return response('Invalid signature', 400);
        }

        try {
            $gateway = $billing->gateway('stripe');
            $gateway->syncSubscriptionFromWebhook($event);
            $eventId = $event['id'] ?? null;
            if ($eventId && ! \DB::table('webhook_events')->where('gateway', 'stripe')->where('event_id', $eventId)->exists()) {
                \DB::table('webhook_events')->insert([
                    'gateway' => 'stripe',
                    'event_id' => $eventId,
                    'type' => $event['type'] ?? null,
                    'processed_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Stripe webhook processing failed', ['error' => $e->getMessage(), 'event' => $event['id'] ?? null]);
            return response('Webhook handler error', 500);
        }

        return response('OK', 200);
    }
}
