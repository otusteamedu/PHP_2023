<?php

namespace Radovinetch\Chat\Command;

use Radovinetch\Chat\Utils;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * В реальных проектах тут будут хранится и кешироваться команды, сейчас сделано по простому
 */
class CommandStorage
{
    /**
     * @throws ReflectionException
     */
    public function getCommand(string $commandName): Command
    {
        $utils = new Utils();
        $files = array_slice(scandir(dirname(__DIR__) . '/' . 'Command'), 2);
        foreach ($files as $file) {
            $class = new ReflectionClass("Radovinetch\Chat\Command\\" . str_replace('.php', '', $file));
            if ($class->isSubclassOf(Command::class) && !$class->isAbstract()) {
                /** @var Command $command */
                $command = $class->newInstanceArgs([$utils]);

                if ($command->getName() === $commandName) {
                    return $command;
                }
            }
        }

        throw new RuntimeException("Команда $commandName не найдена");
    }
}