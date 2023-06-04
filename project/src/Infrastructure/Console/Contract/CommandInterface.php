<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Contract;

interface CommandInterface
{
    public function run(): void;
}
