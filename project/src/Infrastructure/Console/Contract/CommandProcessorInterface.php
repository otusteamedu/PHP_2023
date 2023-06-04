<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Contract;

use DI\Container;

interface CommandProcessorInterface
{
    public function run(Container $container, array $argv): void;
}
