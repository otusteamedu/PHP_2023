<?php

use App\Domain\Repository\ApplicationFormInterface;
use App\Domain\Repository\StatusInterface;
use App\Infrastructure\Queues\Publisher\PublisherInterface;
use App\Infrastructure\Queues\Publisher\RabbitMQPublisher;
use App\Infrastructure\Repository\RepositoryApplicationFormDb;
use App\Infrastructure\Repository\RepositoryStatusDb;
use App\Infrastructure\Db\Db;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    Db::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    PublisherInterface::class => function (ContainerInterface $container) {
        return new RabbitMQPublisher();
    },

    ApplicationFormInterface::class => function (ContainerInterface $container) {
        return $container->get(RepositoryApplicationFormDb::class);
    },

    StatusInterface::class => function (ContainerInterface $container) {
        return $container->get(RepositoryStatusDb::class);
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool) $settings['display_error_details'],
            (bool) $settings['log_errors'],
            (bool) $settings['log_error_details']
        );
    },
];
