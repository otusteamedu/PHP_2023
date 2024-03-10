<?php

use App\Domain\Repository\ApplicationFormInterface;
use App\Infrastructure\Notification\EmailEmailNotification;
use App\Infrastructure\Notification\EmailNotificationInterface;
use App\Infrastructure\Queues\Publisher\PublisherInterface;
use App\Infrastructure\Queues\Publisher\RabbitMQPublisher;
use App\Infrastructure\Repository\DbRepository;
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

    PublisherInterface::class => function (ContainerInterface $container) {
        return new RabbitMQPublisher();
    },

    ApplicationFormInterface::class => function (ContainerInterface $container) {
        return new DbRepository();
    },

    EmailNotificationInterface::class => function (ContainerInterface $container) {
        return new EmailEmailNotification();
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
