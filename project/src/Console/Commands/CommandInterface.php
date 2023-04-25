<?php

declare(strict_types=1);

namespace Vp\App\Console\Commands;

interface CommandInterface
{
    public function run(string $object): void;
}
