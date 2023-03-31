<?php

namespace App;

use App\Server\Server;
use App\Client\Client;
use App\Socket\SocketService;

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
                $server = new Server($socketPath, new SocketService());
                foreach ($server->start() as $message) {
                    echo $message;
                }
                break;
            case 'client':
                $client = new Client($socketPath, new SocketService());
                foreach ($client->start() as $message) {
                    echo $message;
                }
                break;
            default:
                throw new \InvalidArgumentException('Invalid command provided');
        }
    }
}
