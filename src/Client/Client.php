<?php

namespace App\Client;

class Client
{
    public function __construct(private readonly string $socketPath)
    {
    }

    public function start(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new \RuntimeException('Could not create socket');
        }

        if (!socket_connect($socket, $this->socketPath)) {
            throw new \RuntimeException('Could not connect to server');
        }

        while (true) {
            $message = fgets(STDIN);
            socket_write($socket, $message);
            $response = socket_read($socket, 4096);
            echo $response . PHP_EOL;
            if (trim($message) === 'shutdown') {
                break;
            }
        }

        socket_close($socket);
    }
}
