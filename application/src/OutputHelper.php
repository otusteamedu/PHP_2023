<?php

declare(strict_types=1);

namespace Gesparo\ES;

class OutputHelper
{
    public function info($message): void
    {
        echo "$message\n";
    }

    public function error($message): void
    {
        echo "\033[0;31m$message\033[0m\n";
    }

    public function success($message): void
    {
        echo "\033[0;32m$message\033[0m\n";
    }

    public function emptyLine(): void
    {
        echo "\n";
    }
}
