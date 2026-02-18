<?php

return [

    'driver' => env('AI_DRIVER', 'gemini'),

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'default_model' => env('GEMINI_DEFAULT_MODEL', 'gemini-1.5-flash'),
        'url' => 'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent',
    ],

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'default_model' => env('OPENAI_DEFAULT_MODEL', 'gpt-4o-mini'),
        'url' => 'https://api.openai.com/v1/chat/completions',
    ],

];
