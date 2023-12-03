<?php

namespace Cases\Php2023\Application\Command;

class App {
    public function run($argv) {
        $commandName = $argv[1] ?? null;

        if (!$commandName) {
            throw new \Exception("No command specified.");
        }

        $command = CommandFactory::create($commandName);
        $command->execute();
    }
}