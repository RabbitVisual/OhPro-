<?php

return [
    'name' => 'Billing',

    'default_gateway' => env('BILLING_DEFAULT_GATEWAY', 'stripe'), // stripe | mercadopago

    'plan_keys' => ['free', 'pro', 'pro_annual'],

    'stripe' => [
        'key' => config('services.stripe.key'),
        'secret' => config('services.stripe.secret'),
        'webhook_secret' => config('services.stripe.webhook_secret'),
        'currency' => config('services.stripe.currency', 'brl'),
    ],

    'mercadopago' => [
        'public_key' => config('services.mercadopago.public_key'),
        'access_token' => config('services.mercadopago.access_token'),
        'webhook_secret' => config('services.mercadopago.webhook_secret'),
    ],
];
