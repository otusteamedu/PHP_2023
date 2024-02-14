<?php

declare(strict_types=1);

namespace App;

class Console
{
    public function run(array $argv)
    {
        $console = new \src\Queue\Infrastructure\Console\Console();
        match ($argv[1]) {
            'readQueue' => $console->readAll(),
            'completed' => $console->setStatusCompletedStatus($argv)
        };
    }
}
