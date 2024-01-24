<?php

namespace Gkarman\Datamaper\Commands;



use Gkarman\Datamaper\Commands\Classes\AbstractCommand;
use Gkarman\Datamaper\Dto\CommandDto;

class CommandFactory
{
    /**
     * @throws \Exception
     */
    public function getCommand(CommandDto $commandDto): AbstractCommand
    {
        $className = $this->getClassName($commandDto->nameCommand);
        if (class_exists($className)) {
            return new $className();
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
        return 'Gkarman\Datamaper\Commands\Classes\\' . $className . 'Command';
    }
}
