<?php

declare(strict_types=1);

use Vp\App\App;
use Vp\App\Application\Contract\AppInterface;
use Vp\App\Application\Contract\FileStorageInterface;
use Vp\App\Application\Contract\GetDataInterface;
use Vp\App\Application\Contract\ImportDataInterface;
use Vp\App\Application\Contract\ListDataInterface;
use Vp\App\Application\Contract\RemoveDataInterface;
use Vp\App\Application\Contract\ReportDataInterface;
use Vp\App\Application\UseCase\FileStorage;
use Vp\App\Application\UseCase\GetData;
use Vp\App\Application\UseCase\ImportData;
use Vp\App\Application\UseCase\ListData;
use Vp\App\Application\UseCase\RemoveData;
use Vp\App\Application\UseCase\ReportData;
use Vp\App\Infrastructure\Console\CommandProcessor;
use Vp\App\Infrastructure\Console\Commands\CommandGet;
use Vp\App\Infrastructure\Console\Commands\CommandImport;
use Vp\App\Infrastructure\Console\Commands\CommandList;
use Vp\App\Infrastructure\Console\Commands\CommandRemove;
use Vp\App\Infrastructure\Console\Commands\CommandReport;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;

return [
    AppInterface::class => DI\create(App::class)
        ->constructor(DI\get(CommandProcessorInterface::class)),
    CommandProcessorInterface::class => DI\create(CommandProcessor::class),

    'import' => DI\create(CommandImport::class)
        ->constructor(DI\get(ImportDataInterface::class)),
    'list' => DI\create(CommandList::class)
        ->constructor(DI\get(ListDataInterface::class)),
    'get' => DI\create(CommandGet::class)
        ->constructor(DI\get(GetDataInterface::class)),
    'remove' => DI\create(CommandRemove::class)
        ->constructor(DI\get(RemoveDataInterface::class)),
    'report' => DI\create(CommandReport::class)
        ->constructor(DI\get(ReportDataInterface::class)),

    ImportDataInterface::class => DI\create(ImportData::class)
        ->constructor(DI\get(FileStorageInterface::class)),
    FileStorageInterface::class => DI\create(FileStorage::class),
    ListDataInterface::class => DI\create(ListData::class),
    GetDataInterface::class => DI\create(GetData::class),
    RemoveDataInterface::class => DI\create(RemoveData::class),
    ReportDataInterface::class => DI\create(ReportData::class),
];
