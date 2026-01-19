<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Client
    |--------------------------------------------------------------------------
    |
    | The default client connection to use when none is specified.
    |
    */

    'default' => env('FORMSERVICES_DEFAULT_CLIENT', 'main'),

    /*
    |--------------------------------------------------------------------------
    | Client Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure multiple client connections for different
    | FormServices APIs. Each connection requires a base_url, credentials,
    | and optional configuration.
    |
    */

    'clients' => [

        'main' => [
            'base_url' => env('FORMSERVICES_MAIN_URL', 'https://api.formservices.com'),
            'login' => env('FORMSERVICES_MAIN_LOGIN', ''),
            'api_key' => env('FORMSERVICES_MAIN_KEY', ''),
            'timeout' => env('FORMSERVICES_MAIN_TIMEOUT', 30),
            'api_version' => env('FORMSERVICES_MAIN_VERSION', '2023'),
            'verify_ssl' => env('FORMSERVICES_MAIN_VERIFY_SSL', true),
        ],

        'secondary' => [
            'base_url' => env('FORMSERVICES_SECONDARY_URL', ''),
            'login' => env('FORMSERVICES_SECONDARY_LOGIN', ''),
            'api_key' => env('FORMSERVICES_SECONDARY_KEY', ''),
            'timeout' => env('FORMSERVICES_SECONDARY_TIMEOUT', 30),
            'api_version' => env('FORMSERVICES_SECONDARY_VERSION', '2023'),
            'verify_ssl' => env('FORMSERVICES_SECONDARY_VERIFY_SSL', true),
        ],

        // Add more clients as needed...

    ],

];