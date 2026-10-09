<?php

return [

    'ai' => [
        'provider_order' => ['mse_proxy', 'ollama', 'openai'],

        'mse_proxy' => [
            'base_url' => env('MSE_PROXY_URL', 'http://localhost:7777/v1'),
            'api_key' => env('MSE_PROXY_KEY', 'change-secret-key-2026'),
            'model' => env('MSE_PROXY_MODEL', 'gpt-4o-mini'),
            'timeout' => env('MSE_PROXY_TIMEOUT', 120),
        ],

        'ollama' => [
            'base_url' => env('OLLAMA_BASE_URL', 'http://localhost:11434'),
            'model' => env('OLLAMA_MODEL', 'llama3.2'),
            'timeout' => env('OLLAMA_TIMEOUT', 120),
        ],

        'openai' => [
            'api_key' => env('OPENAI_API_KEY', ''),
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
            'timeout' => env('OPENAI_TIMEOUT', 60),
        ],
    ],

    'feed' => [
        'fetch_interval_minutes' => env('FEED_FETCH_INTERVAL', 15),
        'max_items_per_feed' => env('FEED_MAX_ITEMS', 50),
        'timeout_seconds' => env('FEED_TIMEOUT', 30),
    ],

    'clustering' => [
        'similarity_threshold' => env('CLUSTERING_THRESHOLD', 0.7),
        'time_window_hours' => env('CLUSTERING_TIME_WINDOW', 48),
        'min_sources_for_story' => env('CLUSTERING_MIN_SOURCES', 2),
    ],

    'languages' => ['en', 'ar', 'fr', 'it', 'es'],

    'default_language' => env('APP_LOCALE', 'en'),
];
