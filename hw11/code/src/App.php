<?php

namespace Gkarman\Otuselastic;

use Gkarman\Otuselastic\Commands\CommandFactory;

class App
{
    /**
     * @throws \Exception
     */
    public function run(): string
    {
        $commandName = $_SERVER['argv'][1];
        $command = (new CommandFactory())->getCommand($commandName);
        $result = $command->run();
        return $result;
    }
}
