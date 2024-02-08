<?php
declare(strict_types=1);

namespace WorkingCode\Hw11\Command;

interface Command
{
    public const SUCCESS = 0;
    public const FAILURE = 1;

    public function execute(): int;
}
