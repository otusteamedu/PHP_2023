<?php

namespace Gkarman\Redis;

use Gkarman\Redis\Commands\CommandFactory;
use Gkarman\Redis\Dto\CommandDto;

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
