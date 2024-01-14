<?php

return [
    'displayErrorDetails' => true, // Should be set to false in production
    'logError'            => false,
    'logErrorDetails'     => false,
    'logger' => [
        'name' => 'slim-app',
        //'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
        'path' => realpath(__DIR__ . '/../logs/app.log'),
        'level' => \Monolog\Logger::DEBUG,
    ],

    'upload_dir' => realpath(__DIR__ . '/../uploads'),

    'twig' => [
        'root_path' => realpath(__DIR__ . '/../twig'),
    ],

    'doctrine' => [
        // Enables or disables Doctrine metadata caching
        // for either performance or convenience during development.
        'dev_mode' => true,

        // Path where Doctrine will cache the processed metadata
        // when 'dev_mode' is false.
        'cache_dir' => __DIR__ . '/../var/doctrine',

        // List of paths where Doctrine will search for metadata.
        // Metadata can be either YML/XML files or PHP classes annotated
        // with comments or PHP8 attributes.
        'metadata_dirs' => [
            realpath(__DIR__ . '/../src/')
        ],

        // The parameters Doctrine needs to connect to your database.
        // These parameters depend on the driver (for instance the 'pdo_sqlite' driver
        // needs a 'path' parameter and doesn't use most of the ones shown in this example).
        // Refer to the Doctrine documentation to see the full list
        // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
        'connection' => [
            'driver' => 'pdo_pgsql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'dbname' => env('DB_NAME', 'default'),
            'user' => env('DB_USER', 'postgres'),
            'password' => env('DB_PASSWORD', 'secret'),
        ],
    ],

    'rabbit-mq' => [
        'host' => env('RABBITMQ_HOST', 'rabbitmq'),
        'port' => env('RABBITMQ_PORT', '5672'),
        'user' => env('RABBITMQ_USER', 'guest'),
        'password' => env('RABBITMQ_PASSWORD', 'guest'),
        'vhost' => env('RABBITMQ_VHOST', '/'),
    ],

    'email' => [
        'host' => env('EMAIL_HOST', 'smtp.gmail.com'),
        'port' => env('EMAIL_PORT', '465'),
        'user' => env('EMAIL_USER', ''),
        'from' => env('EMAIL_USER', ''),
        'password' => env('EMAIL_PASSWORD', ''),
    ]
];