<?php

declare(strict_types=1);

namespace Dshevchenko\Brownchat;

class App
{
    public function run($argv): void
    {
        $argc = count($argv);

        if ($argc > 0) {
            $param = strtolower($argv[1]);
            if ($param == 'server') {
                $instance = new Server();
            } elseif ($param == 'client') {
                $instance = new Client();
            } elseif ($param == 'help') {
                // Do nothing
            } else {
                Console::write('Unknown command: ' . $param);
            }
        }

        if (isset($instance)) {
            $instance->run();
        } else {
            $this->showHelp();
        }
    }

    private function showHelp(): void
    {
        Console::write('Usage: App.php COMMAND');
        Console::write('');
        Console::write('Commands:');
        Console::write('  help      display brownchat help');
        Console::write('  server    start brownchat server');
        Console::write('  client    start brownchat client');
    }
}
