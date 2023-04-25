<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Exception;
use Vp\App\Console\Commands\CommandInterface;
use Vp\App\Exceptions\CommandNotFound;
use Vp\App\Exceptions\CommandNotObject;
use Vp\App\Exceptions\CommandNotSpecified;

class ConsoleCommandManager
{
    /**
     * @throws Exception
     */
    public function run(array $argv): void
    {
        if (count($argv) < 3) {
            throw new Exception("Provide parameters: [action] [object]");
        }

        $command = $this->getCommandNameFromArgv($argv);
        $object = $this->getObjectFromArgv($argv);

        if (($command === null) || ($object === null)) {
            throw new CommandNotSpecified("Command name is not specified.");
        }

        $commandObj = $this->createCommand($command);

        if (!$commandObj instanceof CommandInterface) {
            throw new CommandNotObject("Command '" . $command ."' is not an object.");
        }

        $commandObj->run($object);
    }

    private function getCommandNameFromArgv(array $argv): ?string
    {
        $command = isset($argv[1]) ? trim($argv[1]) : null;

        if ($command === null) {
            return null;
        }

        return ucfirst($command);
    }

    private function getObjectFromArgv(array $argv): ?string
    {
        return isset($argv[2]) ? trim($argv[2]) : null;
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
        $className = 'Vp\\App\\Console\\Commands\\Command' . $command;

        if (!class_exists($className)) {
            throw new CommandNotFound("Command '" . $command ."' does not exist.");
        }

        return $className;
    }
}
