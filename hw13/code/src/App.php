<?php

namespace Gkarman\Datamaper;

use Gkarman\Datamaper\Commands\CommandFactory;
use Gkarman\Datamaper\Dto\CommandDto;

class App
{
    /**
     * @throws \Exception
     */
    public function run(): string
    {
        $commandDto = new CommandDto($_SERVER['argv']);
        $command = (new CommandFactory())->getCommand($commandDto);
        $result = $command->run();
        return $result;
    }
}
