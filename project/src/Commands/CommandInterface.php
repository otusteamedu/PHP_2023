<?php

declare(strict_types=1);

namespace Vp\App\Commands;

interface CommandInterface
{
    public function run(): void;
}
