<?php

declare(strict_types=1);

namespace User\Php2023;

use User\Php2023\Application\QueueConsumeHandler;
use User\Php2023\Application\Service\StatementQueueService;
use User\Php2023\Application\StatementRequestHandler;
use User\Php2023\Infrastructure\Notification\TelegramNotifier;
use User\Php2023\Infrastructure\Queue\RabbitMQQueue;

class DependencyInjectionBootstrap
{
    public static function setUp(DIContainer $container): void
    {
        $container->set(RabbitMQQueue::class, function () {
            return new RabbitMQQueue('requests');
        });

        $container->set(StatementRequestHandler::class, function ($container) {
            return new StatementRequestHandler(
                $container->get(RabbitMQQueue::class)
            );
        });

        $container->set(StatementQueueService::class, function ($container) {
            return new StatementQueueService(
                $container->get(StatementRequestHandler::class)
            );
        });

        $container->set(TelegramNotifier::class, function () {
            return new TelegramNotifier(
                $_ENV['TELEGRAM_TOKEN'],
                $_ENV['TELEGRAM_BOT_NAME'],
                $_ENV['TELEGRAM_CHAT_ID'],
            );
        });

        $container->set(QueueConsumeHandler::class, function ($container) {
            return new QueueConsumeHandler(
                $container->get(TelegramNotifier::class)
            );
        });

    }
}
