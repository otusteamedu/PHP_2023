<?php

declare(strict_types=1);

namespace App\Socket;

use Socket;

class SocketService implements SocketInterface
{
    public function create(int $domain, int $type, int $protocol = 0): Socket
    {
        $socket = socket_create($domain, $type, $protocol);
        if (!$socket) {
            throw new \RuntimeException('Could not create socket');
        }

        return $socket;
    }

    public function connect(Socket $socket, string $address, ?int $port = null): void
    {
        if (!socket_connect($socket, $address, $port)) {
            throw new \RuntimeException('Could not connect to server');
        }
    }

    public function write(Socket $socket, string $data, ?int $length = null): false|int
    {
        return socket_write($socket, $data, $length);
    }

    public function read(Socket $socket, int $length, int $mode = PHP_BINARY_READ): false|string
    {
        return socket_read($socket, 4096, $mode);
    }

    public function bind(Socket $socket, string $address, int $port = 0): void
    {
        if (!socket_bind($socket, $address, $port)) {
            throw new \RuntimeException('Could not bind socket to path');
        }
    }

    public function listen(Socket $socket, int $backlog = 0): void
    {
        if (!socket_listen($socket)) {
            throw new \RuntimeException('Could not listen on socket');
        }
    }

    public function accept(Socket $socket): false|Socket
    {
        return socket_accept($socket);
    }

    public function close(Socket $socket): void
    {
        socket_close($socket);
    }

    public function shutdown(string $message): bool
    {
        return trim($message) === 'shutdown';
    }
}
