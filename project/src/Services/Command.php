<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Exception;

/**
 * Runs a console command.
 */
class Command
{
    private ConsoleCommandManager $commandManager;

    public function __construct(ConsoleCommandManager $commandManager)
    {
        $this->commandManager = $commandManager;
    }

    public function run(array $argv): void
    {
        try {
            $this->commandManager->run($argv);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
