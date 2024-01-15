<?php

return
[
    'paths' => [
        'migrations' => __DIR__ . '/db/migrations',
        'seeds' => __DIR__ . '/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'pgsql',
            'host' => env('DB_HOST', 'localhost'),
            'name' => env('DB_NAME', 'default'),
            'user' => env('DB_USER', 'postgres'),
            'pass' => env('DB_PASSWORD', 'secret'),
            'port' => env('DB_PORT', '5432'),
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'pgsql',
            'host' => env('DB_HOST', 'localhost'),
            'name' => env('DB_NAME', 'default'),
            'user' => env('DB_USER', 'postgres'),
            'pass' => env('DB_PASSWORD', 'secret'),
            'port' => env('DB_PORT', '5432'),
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'pgsql',
            'host' => env('DB_HOST', 'localhost'),
            'name' => env('DB_NAME', 'default'),
            'user' => env('DB_USER', 'postgres'),
            'pass' => env('DB_PASSWORD', 'secret'),
            'port' => env('DB_PORT', '5432'),
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
