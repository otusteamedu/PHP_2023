<?php

namespace Cases\Php2023\Application\Command;

class App {
    public function run($argv): ?string
    {
        $commandName = $argv[1] ?? null;

        if (!$commandName) {
            throw new \Exception("No command specified.");
        }

        $command = CommandFactory::create($commandName);
        return $command->execute(
            $argv[2] ?? null, $argv[3] ?? null, $argv[4] ?? null, $argv[5] ?? null, $argv[6] ?? null
        );
    }
}