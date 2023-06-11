<?php

namespace App;

use App\Interface\CLI;
use App\Server\Server;
use App\Transport\Socket\Socket;
use Error;

class App
{
    public function run(): void
    {
        $config = new ConfigSocketReader('config.ini');

        if (!$type = $_SERVER['argv'][1]) {
            throw new Error('Write type: server or client');
        }

        $socket = new Socket($config->getPathToFile(), $config->getMaxBytes());

        switch ($type) {
            case 'server':
                $server = new Server($socket);
                $server->start();
                break;
            case 'client':
                $client = new CLI($socket);
                $client->start();
                break;
        }
    }
}
