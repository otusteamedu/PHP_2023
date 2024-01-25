#!/usr/bin/env php
<?php

declare(strict_types=1);

namespace Application;

use Application\Command\Search\Search;
use Symfony\Component\Console\Application as Console;

class App
{
    private Console $console;

    public function __construct()
    {
        $this->console = new Console();
    }

    public function run(): void
    {
        $this->console->add(new Search());
        $this->console->run();
    }
}
