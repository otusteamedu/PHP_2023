<?php

declare(strict_types=1);

use Vp\App\Application\Builder\AmqpConnectionBuilder;
use Vp\App\Application\Builder\PostgresConnectionBuilder;
use Vp\App\Application\ConsoleApp;
use Vp\App\Application\Contract\AppInterface;
use Vp\App\Application\Contract\HelpDataInterface;
use Vp\App\Application\Contract\InitDataInterface;
use Vp\App\Application\Contract\OrderDataInterface;
use Vp\App\Application\RabbitMq\Contract\RabbitReceiverInterface;
use Vp\App\Application\RabbitMq\RabbitReceiver;
use Vp\App\Application\UseCase\Contract\OrderHandlerInterface;
use Vp\App\Application\UseCase\HelpData;
use Vp\App\Application\UseCase\InitData;
use Vp\App\Application\UseCase\OrderDataProcess;
use Vp\App\Application\UseCase\OrderHandler;
use Vp\App\Domain\Contract\DatabaseInterface;
use Vp\App\Infrastructure\Console\CommandProcessor;
use Vp\App\Infrastructure\Console\Commands\CommandHelp;
use Vp\App\Infrastructure\Console\Commands\CommandInit;
use Vp\App\Infrastructure\Console\Commands\CommandOrders;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;
use Vp\App\Infrastructure\DataBase\PgDatabase;

return [
    AppInterface::class => DI\create(ConsoleApp::class)
        ->constructor(DI\get(CommandProcessorInterface::class)),

    DatabaseInterface::class => DI\create(PgDatabase::class)
        ->constructor(
            (new PostgresConnectionBuilder())
                ->setUser($_ENV['DB_USERNAME'])
                ->setPassword($_ENV['DB_PASSWORD'])
                ->setPort($_ENV['DB_PORT'])
                ->setHost($_ENV['DB_HOST'])
                ->setName($_ENV['DB_NAME'])
        ),

    CommandProcessorInterface::class => DI\create(CommandProcessor::class),

    HelpDataInterface::class => DI\create(HelpData::class),

    InitDataInterface::class => DI\create(InitData::class)
        ->constructor(DI\get(DatabaseInterface::class)),

    OrderHandlerInterface::class => DI\create(OrderHandler::class)
        ->constructor(
            DI\get(DatabaseInterface::class)
        ),

    RabbitReceiverInterface::class => DI\create(RabbitReceiver::class)
        ->constructor(
            (new AmqpConnectionBuilder())
                ->setHost($_ENV['RBMQ_HOST'])
                ->setPort($_ENV['RBMQ_PORT'])
                ->setUser($_ENV['RBMQ_USER'])
                ->setPassword($_ENV['RBMQ_PASSWORD'])
                ->build()
        ),

    OrderDataInterface::class => DI\create(OrderDataProcess::class)
        ->constructor(
            DI\get(RabbitReceiverInterface::class),
            DI\get(OrderHandlerInterface::class)
        ),

    'help' => DI\create(CommandHelp::class)
        ->constructor(DI\get(HelpDataInterface::class)),
    'init' => DI\create(CommandInit::class)
        ->constructor(DI\get(InitDataInterface::class)),
    'orders' => DI\create(CommandOrders::class)
        ->constructor(DI\get(OrderDataInterface::class))
];
