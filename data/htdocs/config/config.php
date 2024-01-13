<?php

return [
    'displayErrorDetails' => true, // Should be set to false in production
    'logError'            => false,
    'logErrorDetails'     => false,

    'db' => [
        'driver' => 'pdo_pgsql',
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', '5432'),
        'dbname' => env('DB_NAME', 'default'),
        'user' => env('DB_USER', 'postgres'),
        'password' => env('DB_PASSWORD', 'secret'),
    ]
];
