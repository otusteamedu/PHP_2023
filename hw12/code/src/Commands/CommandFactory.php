<?php

namespace Gkarman\Redis\Commands;

use Gkarman\Redis\Commands\Classes\AbstractCommand;
use Gkarman\Redis\Dto\CommandDto;

class CommandFactory
{
    /**
     * @throws \Exception
     */
    public function getCommand(CommandDto $commandDto): AbstractCommand
    {
        $className = $this->getClassName($commandDto->nameCommand);
        if (class_exists($className)) {
            return new $className($commandDto);
        }

        throw new \Exception('Такой команды нет');
    }

    private function getClassName(string $command): string
    {
        $words = explode('_', $command);
        $className = '';
        foreach ($words as $word) {
            $className .= ucfirst($word);
        }
        return 'Gkarman\Redis\Commands\Classes\\' . $className . 'Command';
    }
}
