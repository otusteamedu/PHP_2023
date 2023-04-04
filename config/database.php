<?php

declare(strict_types=1);

return [
    'pgsql' => [
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'dsn' => "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};user={$_ENV['DB_USERNAME']};password={$_ENV['DB_PASSWORD']}",
    ],
    'sqlite' => [
        'path' => $_ENV['SQLITE_DB_PATH'],
        'dsn' => "sqlite:{$_ENV['SQLITE_DB_PATH']}",
    ]
];
