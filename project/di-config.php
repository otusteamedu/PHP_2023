<?php

declare(strict_types=1);

use Vp\App\App;
use Vp\App\Application\Contract\AppInterface;
use Vp\App\Infrastructure\Console\CommandProcessor;
use Vp\App\Infrastructure\Console\Commands\CommandImport;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;

return [
    AppInterface::class => DI\create(App::class)
        ->constructor(DI\get(CommandProcessorInterface::class)),
    CommandProcessorInterface::class => DI\create(CommandProcessor::class),
    'import' => DI\create(CommandImport::class),
];
