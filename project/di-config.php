<?php

declare(strict_types=1);

use Vp\App\Application\Builder\AmqpConnectionBuilder;
use Vp\App\Application\ConsoleApp;
use Vp\App\Application\Contract\AppInterface;
use Vp\App\Application\Contract\ConsoleDataInterface;
use Vp\App\Application\Contract\HelpDataInterface;
use Vp\App\Application\Contract\TreeDataInterface;
use Vp\App\Application\Handler\ConsoleHandler;
use Vp\App\Application\Handler\Contract\ConsoleHandlerInterface;
use Vp\App\Application\RabbitMq\RabbitReceiver;
use Vp\App\Application\UseCase\ConsoleDataProcess;
use Vp\App\Application\UseCase\Contract\StatementGeneratorInterface;
use Vp\App\Application\UseCase\HelpData;
use Vp\App\Application\UseCase\StatementGenerator;
use Vp\App\Infrastructure\Console\CommandProcessor;
use Vp\App\Infrastructure\Console\Commands\CommandConsole;
use Vp\App\Infrastructure\Console\Commands\CommandHelp;
use Vp\App\Infrastructure\Console\Commands\CommandTree;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;
use Vp\App\Infrastructure\Console\Contract\OutputInterface;
use Vp\App\Infrastructure\Console\Output;

return [
    AppInterface::class => DI\create(ConsoleApp::class)
        ->constructor(DI\get(CommandProcessorInterface::class)),
    CommandProcessorInterface::class => DI\create(CommandProcessor::class),
    OutputInterface::class => DI\create(Output::class),
    StatementGeneratorInterface::class => DI\create(StatementGenerator::class),

    ConsoleHandlerInterface::class => DI\create(ConsoleHandler::class)
        ->constructor(
            DI\get(StatementGeneratorInterface::class),
            DI\get(OutputInterface::class),
        ),
//
//    LandPlotFactoryBuilderInterface::class => DI\create(LandPlotFactoryBuilder::class),
//    TreeLandPlotBuilderInterface::class => DI\create(TreeLandPlotBuilder::class),

    'help' => DI\create(CommandHelp::class)
        ->constructor(DI\get(HelpDataInterface::class)),
    'console' => DI\create(CommandConsole::class)
        ->constructor(DI\get(ConsoleDataInterface::class)),
    'tree' => DI\create(CommandTree::class)
        ->constructor(DI\get(TreeDataInterface::class)),

//    ValidatorInterface::class => DI\create(Validator::class)
//        ->constructor((new LengthResultHandler())->setNext(new XssResultHandler())),
//
    HelpDataInterface::class => DI\create(HelpData::class),
    ConsoleDataInterface::class => DI\create(ConsoleDataProcess::class)
        ->constructor(
            new RabbitReceiver(
            (new AmqpConnectionBuilder())
                ->setHost($_ENV['RBMQ_HOST'])
                ->setPort($_ENV['RBMQ_PORT'])
                ->setUser($_ENV['RBMQ_USER'])
                ->setPassword($_ENV['RBMQ_PASSWORD'])
                ->build()
            ),
            DI\get(ConsoleHandlerInterface::class)
        ),
//    TreeDataInterface::class => DI\create(TreeData::class)
//        ->constructor(
//            DI\get(DatabaseInterface::class),
//            DI\get(LandPlotFactoryBuilderInterface::class),
//            DI\get(TreeLandPlotBuilderInterface::class),
//            DI\get(ValidatorInterface::class),
//        ),
];
