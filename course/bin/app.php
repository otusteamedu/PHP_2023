<?php

use Cases\Php2023\Application\Command\CommandFactory;

require __DIR__.'/../vendor/autoload.php';


try {
    $commandName = $argv[1] ?? null;
    if (!$commandName) {
        throw new Exception("No command specified.");
    }

    $command = CommandFactory::create($commandName);
    $command->execute();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}