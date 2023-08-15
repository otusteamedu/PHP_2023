<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Container\ContainerInterface;
use Root\App\Settings;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        PDO::class => function (ContainerInterface $c) {
            $settings = $c->get(Settings::class);
            $pdoSettings = $settings->get('pdo');

            $pdo = new PDO("pgsql:host={$pdoSettings['host']};port={$pdoSettings['port']};" .
                "dbname={$pdoSettings['dbname']};user={$pdoSettings['user']};password={$pdoSettings['password']}");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        },
        AMQPStreamConnection::class => function (ContainerInterface $c) {
            $settings = $c->get(Settings::class);
            $settings = $settings->get('rabbitmq');

            return new AMQPStreamConnection(
                $settings['host'],
                $settings['port'],
                $settings['user'],
                $settings['password']
            );
        }
    ]);
};
