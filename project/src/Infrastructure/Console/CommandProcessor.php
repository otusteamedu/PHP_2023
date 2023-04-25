<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Vp\App\Infrastructure\Console\Commands\CommandInterface;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;
use Vp\App\Infrastructure\Exception\CommandNotFound;
use Vp\App\Infrastructure\Exception\CommandNotObject;
use Vp\App\Infrastructure\Exception\CommandNotSpecified;
use DI\Container;

class CommandProcessor implements CommandProcessorInterface
{
    /**
     * @throws Exception
     * @throws CommandNotSpecified
     * @throws CommandNotFound
     * @throws CommandNotObject
     */
    public function run(Container $container, array $argv): void
    {
        if (count($argv) < 3) {
            throw new Exception("Provide parameters: [action] [object]");
        }

        $command = isset($argv[1]) ? trim($argv[1]) : null;
        $object = isset($argv[2]) ? trim($argv[2]) : null;

        if (($command === null) || ($object === null)) {
            throw new CommandNotSpecified("Command name is not specified.");
        }

        try {
            $commandObj = $container->get($command);
        } catch (DependencyException | NotFoundException $e) {
            throw new CommandNotFound("Command '" . $command ."' does not exist.");
        }

        if (!$commandObj instanceof CommandInterface) {
            throw new CommandNotObject("Command '" . $command ."' is not an object.");
        }

        $commandObj->run($object);
    }
}
