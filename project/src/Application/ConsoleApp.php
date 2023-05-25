<?php

declare(strict_types=1);

namespace Vp\App\Application;

use DI\Container;
use Exception;
use Vp\App\Application\Contract\AppInterface;
use Vp\App\Infrastructure\Console\Contract\CommandProcessorInterface;

/**
 * Runs a console command.
 */
class ConsoleApp implements AppInterface
{
    private CommandProcessorInterface $commandProcessor;

    public function __construct(CommandProcessorInterface $commandProcessor)
    {
        $this->commandProcessor = $commandProcessor;
    }

    public function run(Container $container, array $argv): void
    {
        try {
            $this->commandProcessor->run($container, $argv);
        } catch (Exception $e) {
            fwrite(STDERR, "Error: " . $e->getMessage() . PHP_EOL);
        }
    }
}
