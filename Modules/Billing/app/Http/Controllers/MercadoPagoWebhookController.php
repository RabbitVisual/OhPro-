<?php

namespace Modules\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Billing\Services\BillingService;

class MercadoPagoWebhookController extends Controller
{
    public function __invoke(Request $request, BillingService $billing): Response
    {
        $payload = $request->all();
        $type = $payload['type'] ?? $payload['action'] ?? '';
        $id = $payload['data']['id'] ?? $payload['id'] ?? null;

        if (! $id) {
            return response('Invalid payload', 400);
        }

        try {
            $gateway = $billing->gateway('mercadopago');
            $gateway->syncSubscriptionFromWebhook($payload);
        } catch (\Throwable $e) {
            Log::error('Mercado Pago webhook failed', ['error' => $e->getMessage(), 'id' => $id]);
            return response('Webhook handler error', 500);
        }

        return response('OK', 200);
    }
}
