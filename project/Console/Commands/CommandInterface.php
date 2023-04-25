<?php

declare(strict_types=1);

namespace Console\Commands;

interface CommandInterface
{
    public function run(string $object): void;
}
