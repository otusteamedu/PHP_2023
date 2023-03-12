<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Exception;
use Vp\App\Commands\CommandInterface;
use Vp\App\Exceptions\CommandNotFound;
use Vp\App\Exceptions\CommandNotObject;
use Vp\App\Exceptions\CommandNotSpecified;

class CommandProcessor
{
    /**
     * @throws Exception
     */
    public function run(array $argv): void
    {
        if (count($argv) < 2) {
            throw new Exception("Provide parameters: [action]");
        }

        $command = $this->getCommandNameFromArgv($argv);

        if ($command === null) {
            throw new CommandNotSpecified("Command name is not specified.");
        }

        $commandObj = $this->createCommand($command);

        if (!$commandObj instanceof CommandInterface) {
            throw new CommandNotObject("Command '" . $command ."' is not an object.");
        }

        $commandObj->run();
    }

    private function getCommandNameFromArgv(array $argv): ?string
    {
        $command = isset($argv[1]) ? trim($argv[1]) : null;

        if ($command === null) {
            return null;
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
            throw new CommandNotFound("Command '" . $command ."' does not exist.");
        }

        return $className;
    }
}
