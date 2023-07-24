<?php

namespace Otus\Hw;

use Otus\Hw\Client;
use Otus\Hw\Server;

class App
{
    public function run()
    {
        global $argv;

        if (is_null($argv[1]) or count($argv) > 2) {
            exit('Вы должны передать 1 аргумент' . PHP_EOL);
        }

        $mode = $argv[1];
        if (!in_array($mode, ['server','client'])) {
            exit('Вы должны передать только server или client' . PHP_EOL);
        }

        if ($mode == 'server') {
            $app = new Server();
        }
        if ($mode == 'client') {
            $app = new Client();
        }

        $app->run();
    }
}
