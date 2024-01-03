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
        $className = $this->getClassName($command);
        if (class_exists($className)) {
            return new $className();
        }

        throw new \Exception('Такой команды нет');
    }

    private function getClassName(string $command): string
    {
        $command = str_replace('_', ' ', $command);
        $words = explode(' ', $command);
        $className = '';
        foreach ($words as $word) {
            $className .= ucfirst($word);
        }
        return 'Gkarman\Otuselastic\Commands\Classes\\' . $className . 'Command';
    }
}
