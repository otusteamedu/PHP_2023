<?php

declare(strict_types=1);

use Vp\App\Application\App;
use Vp\App\Application\Builder\Contract\TreeLandPlotBuilderInterface;
use Vp\App\Application\Builder\RabbitReceiverBuilder;
use Vp\App\Application\Builder\TreeLandPlotBuilder;
use Vp\App\Application\ConsoleApp;
use Vp\App\Application\Contract\AppInterface;
use Vp\App\Application\Contract\ConsoleDataInterface;
use Vp\App\Application\Contract\HelpDataInterface;
use Vp\App\Application\Contract\InitDataInterface;
use Vp\App\Application\Contract\TreeDataInterface;
use Vp\App\Application\FactoryBuilder\Contract\LandPlotFactoryBuilderInterface;
use Vp\App\Application\FactoryBuilder\LandPlotFactoryBuilder;
use Vp\App\Application\Handler\LengthResultHandler;
use Vp\App\Application\Handler\XssResultHandler;
use Vp\App\Application\UseCase\ConsoleDataProcess;
use Vp\App\Application\UseCase\HelpData;
use Vp\App\Application\UseCase\InitData;
use Vp\App\Application\UseCase\TreeData;
use Vp\App\Application\Validator\Contract\ValidatorInterface;
use Vp\App\Application\Validator\Validator;
use Vp\App\Infrastructure\Console\CommandProcessor;
use Vp\App\Infrastructure\Console\Commands\CommandHelp;
use Vp\App\Infrastructure\Console\Commands\CommandConsole;
use Vp\App\Infrastructure\Console\Commands\CommandTree;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;
use Vp\App\Infrastructure\DataBase\Contract\DatabaseInterface;
use Vp\App\Infrastructure\DataBase\Database;

$receiverBuilder = new RabbitReceiverBuilder();
$receiverBuilder
    ->setHost($_ENV['RBMQ_HOST'])
    ->setPort($_ENV['RBMQ_PORT'])
    ->setUser($_ENV['RBMQ_USER'])
    ->setPassword($_ENV['RBMQ_PASSWORD'])
    ;

return [
    AppInterface::class => DI\create(ConsoleApp::class)
        ->constructor(DI\get(CommandProcessorInterface::class)),
    CommandProcessorInterface::class => DI\create(CommandProcessor::class),

    DatabaseInterface::class => DI\create(Database::class)
        ->constructor($_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT'], $_ENV['DB_NAME']),
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
        ->constructor($receiverBuilder->build()),
//    TreeDataInterface::class => DI\create(TreeData::class)
//        ->constructor(
//            DI\get(DatabaseInterface::class),
//            DI\get(LandPlotFactoryBuilderInterface::class),
//            DI\get(TreeLandPlotBuilderInterface::class),
//            DI\get(ValidatorInterface::class),
//        ),
];
