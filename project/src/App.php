<?php

declare(strict_types=1);

namespace Vp\App;

use Vp\App\Services\CommandProcessor;
use Exception;

class App
{
    private CommandProcessor $commandProcessor;

    public function __construct(CommandProcessor $commandProcessor)
    {
        $this->commandProcessor = $commandProcessor;
    }

    public function run(array $argv): void
    {
        try {
            $this->commandProcessor->run($argv);
        } catch (Exception $e) {
            fwrite(STDOUT, "Error: " . $e->getMessage() . PHP_EOL);
        }
    }
}
