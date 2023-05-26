<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\ConsoleDataInterface;
use Vp\App\Infrastructure\Console\Contract\CommandInterface;

class CommandConsole implements CommandInterface
{
    private ConsoleDataInterface $consoleData;

    public function __construct(ConsoleDataInterface $consoleData)
    {
        $this->consoleData = $consoleData;
    }

    public function run(): void
    {
        $this->consoleData->work();
    }
}
