<?php

declare(strict_types=1);

namespace App;

use Exception;

class Socket
{
    private $socket;
    private string $socketPath;

    public function __construct($socketPath)
    {
        $this->socketPath = $socketPath;
    }

    public function create(): void
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_bind($this->socket, $this->socketPath);
        socket_listen($this->socket);
        echo 'Socket has created' . PHP_EOL;
    }

    public function read(): array
    {
        $clientSocket = socket_accept($this->socket);
        if (!$clientSocket) {
            echo "socket_accept() failed: " . socket_strerror(socket_last_error($this->socket)) . "\n";
            return [null, null];
        }
        $message = socket_read($clientSocket, 1024);

        return [$clientSocket, $message];
    }

    public function write(\Socket $socket, string $message): void
    {
        socket_write($socket, $message, strlen($message));
    }

    /**
     * @throws Exception
     */
    public function connect(): bool
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        return socket_connect($this->socket, $this->socketPath);
    }

    public function clientRead(): false|string
    {
        $message = socket_read($this->socket, 1024);
        return $message;
    }

    public function getSocket()
    {
        return $this->socket;
    }

    public function disconnect(): void
    {
        socket_close($this->socket);
    }
}
