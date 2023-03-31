<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Exception;
use Vp\App\Commands\CommandInterface;
use Vp\App\Exceptions\CommandNotFound;
use Vp\App\Exceptions\CommandNotObject;

class CommandProcessor
{
    private const DEFAULT_COMMAND = 'help';

    /**
     * @throws Exception
     */
    public function run(array $argv): void
    {
        $command = $this->getCommandNameFromArgv($argv);
        $commandObj = $this->createCommand($command);

        if (!$commandObj instanceof CommandInterface) {
            throw new CommandNotObject("Command '" . $command . "' is not an object.");
        }

        $commandObj->run($argv);
    }

    private function getCommandNameFromArgv(array $argv): string
    {
        $command = isset($argv[1]) ? trim($argv[1]) : null;

        if ($command === null) {
            $command = self::DEFAULT_COMMAND;
        }

        return ucfirst($command);
    }

    /**
     * @throws CommandNotFound
     */
    private function createCommand(string $command): object
    {
        $className = $this->getClassName($command);

        return new $className();
    }

    /**
     * @throws CommandNotFound
     */
    private function getClassName(string $command): string
    {
        $className = 'Vp\\App\\Commands\\Command' . $command;

        if (!class_exists($className)) {
            throw new CommandNotFound("Command '" . $command . "' does not exist.");
        }

        return $className;
    }
}
