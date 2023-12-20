<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure;

use Gesparo\Homework\Domain\OutputInterface;

class ConsoleOutputHelper implements OutputInterface
{
    public function send(string $message): void
    {
        echo $message . PHP_EOL;
    }
}
