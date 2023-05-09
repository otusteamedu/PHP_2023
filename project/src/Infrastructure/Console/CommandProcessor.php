<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Vp\App\Infrastructure\Console\Contract\CommandInterface;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;
use DI\Container;
use Vp\App\Infrastructure\Exception\CommandNotFound;
use Vp\App\Infrastructure\Exception\CommandNotObject;
use Vp\App\Infrastructure\Exception\CommandNotSpecified;

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
        if (count($argv) < 2) {
            throw new Exception("Provide parameters: [action]");
        }

        $command = isset($argv[1]) ? trim($argv[1]) : null;

        if ($command === null) {
            throw new CommandNotSpecified("Command name is not specified.");
        }

        try {
            $commandObj = $container->get($command);
        } catch (DependencyException | NotFoundException $e) {
            throw new CommandNotFound("Command '" . $command . "' does not exist.");
        }

        if (!$commandObj instanceof CommandInterface) {
            throw new CommandNotObject("Command '" . $command . "' is not an object.");
        }

        $commandObj->run();
    }
}
