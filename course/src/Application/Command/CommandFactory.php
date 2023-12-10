<?php

namespace Cases\Php2023\Application\Command;


class CommandFactory {
    public static function create($commandName) {
        $className = "Cases\\Php2023\\Application\\Command\\" . $commandName . "Command";
        if (class_exists($className)) {
            return new $className();
        }

        throw new \Exception("Command not found.");
    }
}