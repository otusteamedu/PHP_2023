<?php

declare(strict_types=1);

namespace Timerkhanov\Elastic;

use Timerkhanov\Elastic\Command\AbstractCommand;
use Timerkhanov\Elastic\Command\LoadBookCommand;
use Timerkhanov\Elastic\Command\SearchBookCommand;
use Timerkhanov\Elastic\Exception\CommandNotFoundException;
use Timerkhanov\Elastic\Repository\Interface\RepositoryInterface;

class App
{
    private static Config $config;

    private array $dependence;

    public function __construct(private readonly array $argv)
    {
        self::$config = new Config(__DIR__ . '/../config.ini');

        $this->dependence = require('dependence.php');
    }

    public static function config(string $name): mixed
    {
        return self::$config->get($name);
    }

    private function getCommand(string $command): AbstractCommand
    {
        return match ($command) {
            'load' => new LoadBookCommand($this->dependence[RepositoryInterface::class], $this->argv),
            'search' => new SearchBookCommand($this->dependence[RepositoryInterface::class], $this->argv),
            default => throw new CommandNotFoundException("Such a command - \"$command\" not found")
        };
    }

    public function run(): void
    {
        $command = $this->getCommand($this->argv[1] ?? '');
        $command->execute();
    }
}
