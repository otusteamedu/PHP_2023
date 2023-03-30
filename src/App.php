<?php

namespace App;

use App\Server\Server;
use App\Client\Client;

class App
{
    public function run(): void
    {
        $config = parse_ini_file(__DIR__ . '/../config.ini', true);
        $socketPath = $config['server']['socket_path'];

        $args = $_SERVER['argv'];
        array_shift($args);

        if (count($args) == 0) {
            throw new \InvalidArgumentException('Not enough arguments provided');
        }

        $command = array_shift($args);

        switch ($command) {
            case 'server':
                $server = new Server($socketPath);
                $server->start();
                break;
            case 'client':
                $client = new Client($socketPath);
                $client->start();
                break;
            default:
                throw new \InvalidArgumentException('Invalid command provided');
        }
    }
}
