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

    /**
     * @throws Exception
     */
    public function run(array $argv): void
    {
        $this->commandProcessor->run($argv);
    }
}
