<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

class App
{
    public function run(): void
    {
        if (!$type = $_SERVER['argv'][1]) {
            throw new RuntimeException('Нет нужного параметра server или client');
        }

        switch ($type) {
            case 'server':
                $socket = new ChatSocket();
                $server = new Server();
                $server->handle($socket);
                break;
            case 'client':
                $socket = new ChatSocket();
                $client = new Client();
                $client->handle($socket);
                break;
            default:
                echo "Неверный аргумент";
                break;
        }
    }
}
