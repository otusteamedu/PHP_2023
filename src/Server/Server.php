<?php

namespace App\Server;

class Server
{
    public function __construct(private readonly string $socketPath)
    {
    }

    public function start(): void
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$socket) {
            throw new \RuntimeException('Could not create socket');
        }

        if (!socket_bind($socket, $this->socketPath)) {
            throw new \RuntimeException('Could not bind socket to path');
        }

        if (!socket_listen($socket)) {
            throw new \RuntimeException('Could not listen on socket');
        }

        $client = socket_accept($socket);
        while (true) {
            $message = socket_read($client, 4096);
            echo $message . PHP_EOL;

            $response = 'Received ' . strlen($message) . ' bytes';
            socket_write($client, $response);
            if (trim($message) === 'shutdown') {
                break;
            }
        }

        socket_close($client);
        socket_close($socket);
    }
}
