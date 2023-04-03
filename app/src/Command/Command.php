<?php

declare(strict_types=1);

namespace Imitronov\Hw7\Command;

interface Command
{
    public function handle(): void;
}
