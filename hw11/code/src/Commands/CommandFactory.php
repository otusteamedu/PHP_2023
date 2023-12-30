<?php

namespace Gkarman\Otuselastic\Commands;

use Gkarman\Otuselastic\Commands\Classes\AbstractCommand;

class CommandFactory
{
    /**
     * @throws \Exception
     */
    public function getCommand(string $command): AbstractCommand
    {
        $command = 'Gkarman\Otuselastic\Commands\Classes\\'. lcfirst($command) . 'Command';

        if (class_exists($command)) {
            return new $command();
        }

        throw new \Exception('Такой команды нет');
    }
}
