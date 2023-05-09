<?php

declare(strict_types=1);

use Vp\App\Application\App;
use Vp\App\Application\Builder\Contract\TreeLandPlotBuilderInterface;
use Vp\App\Application\Builder\TreeLandPlotBuilder;
use Vp\App\Application\Contract\AppInterface;
use Vp\App\Application\Contract\HelpDataInterface;
use Vp\App\Application\Contract\InitDataInterface;
use Vp\App\Application\Contract\TreeDataInterface;
use Vp\App\Application\FactoryBuilder\Contract\LandPlotFactoryBuilderInterface;
use Vp\App\Application\FactoryBuilder\LandPlotFactoryBuilder;
use Vp\App\Application\UseCase\HelpData;
use Vp\App\Application\UseCase\InitData;
use Vp\App\Application\UseCase\TreeData;
use Vp\App\Infrastructure\Console\CommandProcessor;
use Vp\App\Infrastructure\Console\Commands\CommandHelp;
use Vp\App\Infrastructure\Console\Commands\CommandInit;
use Vp\App\Infrastructure\Console\Commands\CommandTree;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;
use Vp\App\Infrastructure\DataBase\Contract\DatabaseInterface;
use Vp\App\Infrastructure\DataBase\Database;

return [
    AppInterface::class => DI\create(App::class)
        ->constructor(DI\get(CommandProcessorInterface::class)),
    CommandProcessorInterface::class => DI\create(CommandProcessor::class),

    DatabaseInterface::class => DI\create(Database::class)
        ->constructor($_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT'], $_ENV['DB_NAME']),

    LandPlotFactoryBuilderInterface::class => DI\create(LandPlotFactoryBuilder::class),
    TreeLandPlotBuilderInterface::class => DI\create(TreeLandPlotBuilder::class),

    'help' => DI\create(CommandHelp::class)
        ->constructor(DI\get(HelpDataInterface::class)),
    'init' => DI\create(CommandInit::class)
        ->constructor(DI\get(InitDataInterface::class)),
    'tree' => DI\create(CommandTree::class)
        ->constructor(DI\get(TreeDataInterface::class)),

    HelpDataInterface::class => DI\create(HelpData::class),
    InitDataInterface::class => DI\create(InitData::class)
        ->constructor(DI\get(DatabaseInterface::class)),
    TreeDataInterface::class => DI\create(TreeData::class)
        ->constructor(
            DI\get(DatabaseInterface::class),
            DI\get(LandPlotFactoryBuilderInterface::class),
            DI\get(TreeLandPlotBuilderInterface::class)
        ),
];
