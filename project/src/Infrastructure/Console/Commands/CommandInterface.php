<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

interface CommandInterface
{
    public function run(string $object): void;
}
