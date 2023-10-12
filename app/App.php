<?php

declare(strict_types=1);

namespace App;

use Exception;
use src\Chat\Client;
use src\Chat\Server;

class App
{
    public function run(): void
    {
        if (count($_SERVER['argv']) != 2 || !in_array($_SERVER['argv'][1], ['server', 'client'])) {
            throw new Exception('Missing required argument');
        }

        switch ($_SERVER['argv'][1]) {
            case 'server':
                $serverSocket = new Server();
                $serverSocket->consoleChat();
                break;
            case 'client':
                $clientSocket = new Client();
                $clientSocket->consoleChat();
                break;
        }
    }
}
