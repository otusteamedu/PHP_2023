#!/usr/bin/env php
<?php

declare(strict_types=1);

namespace Application;

use Application\Command\Search\Search;
use Symfony\Component\Console\Application as Console;
use Dotenv\Dotenv;

class App
{
    private Console $console;

    public function __construct()
    {
        $this->console = new Console();
        $this->console->add(new Search());

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    public function run(): void
    {
        $this->console->run();
    }
}
