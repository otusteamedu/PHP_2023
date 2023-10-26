<?php

declare(strict_types=1);

namespace Gesparo\ES;

use Gesparo\ES\Command\CommandStrategy;

class App
{
    private string $rootPath;
    private array $argv;

    public function __construct(string $rootPath, array $argv)
    {
        $this->rootPath = $rootPath;
        $this->argv = $argv;
    }

    public function run(): void
    {
        $this->initEnvironment();

        (new CommandStrategy(ArgvManager::getInstance()))->get()->run();
    }

    private function initEnvironment(): void
    {
        PathHelper::initInstance($this->rootPath);
        ArgvManager::initInstance($this->argv);
    }
}
