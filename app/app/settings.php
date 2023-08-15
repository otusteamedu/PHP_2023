<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Root\App\Settings;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        Settings::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'pdo' => [
                    'host' => $_ENV['PDO_HOST'] ?? 'postgresql',
                    'port' => $_ENV['PDO_PORT'] ?? 5432,
                    'dbname' =>  $_ENV['PDO_DBNAME'] ?? 'db',
                    'user' => $_ENV['PDO_USER'] ?? 'user',
                    'password' => $_ENV['PDO_PASSWORD'] ?? 'password'
                ],
                'rabbitmq' => [
                    'host' => $_ENV['RABBITMQ_HOST'] ?? 'rabbitmq',
                    'port' => $_ENV['RABBITMQ_PORT'] ?? 5672,
                    'user' => $_ENV['RABBITMQ_USER'] ?? 'user',
                    'password' => $_ENV['RABBITMQ_PASSWORD'] ?? 'password',
                    'queryName' => $_ENV['RABBITMQ_QUERY_NAME'] ?? 'task',
                ]
            ]);
        }
    ]);
};
