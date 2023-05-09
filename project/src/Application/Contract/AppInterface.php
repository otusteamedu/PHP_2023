<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

use DI\Container;

interface AppInterface
{
    public function run(Container $container, array $argv): void;
}
