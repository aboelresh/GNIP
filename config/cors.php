<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS)
    |--------------------------------------------------------------------------
    |
    | CORS is configured here for the API routes. The allowed_origins list
    | should contain the frontend origin in production. Using '*' is
    | acceptable for local development but should not be used in production
    | when the API uses cookie-based authentication.
    |
    | Why this matters: if a malicious site sends requests to this API from
    | a user's browser, the browser will block the response unless the API
    | explicitly allows that origin. CORS is a browser-enforced mechanism,
    | not a server-side security control on its own.
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_filter(
        explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000,http://localhost:5173'))
    ),

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'Authorization',
        'Accept',
        'X-Requested-With',
    ],

    'exposed_headers' => [
        'X-RateLimit-Limit',
        'X-RateLimit-Remaining',
        'Retry-After',
    ],

    'max_age' => 86400,

    'supports_credentials' => false,

];