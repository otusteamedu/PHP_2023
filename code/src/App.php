<?php

namespace Radovinetch\Chat;

use Radovinetch\Chat\Command\Command;
use Radovinetch\Chat\Command\CommandStorage;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

class App
{
    protected CommandStorage $commandStorage;

    public function __construct() {
        $this->commandStorage = new CommandStorage();
    }

    /**
     * @throws ReflectionException
     */
    public function run(array $argv): void
    {
        $this->commandStorage->getCommand($argv[1])->execute($argv);
    }
}