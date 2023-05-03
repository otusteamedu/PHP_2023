<?php

namespace Yakovgulyuta\Hw7\Chat;

use Socket;

class SocketInstance
{

    private string $socketPath = '/socket/chat.sock';

    private Socket $socket;

    private function __construct(?\Socket $socket = null)
    {
        if (is_null($socket)) {
            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        }
        $this->socket = $socket;
    }

    public static function create(): self
    {
        return new self();
    }


    public function accept(): SocketInstance
    {
        $socket = socket_accept($this->socket);
        return new self($socket);
    }


    public function bind(): void
    {
        socket_bind($this->socket, $this->socketPath);
    }


    public function connect(): void
    {
        socket_connect($this->socket, $this->socketPath);
    }


    public function listen(int $backlog): void
    {
        socket_listen($this->socket, $backlog);
    }

    public function read(): string
    {
        return socket_read($this->socket, 4096);
    }

    public function write(string $message): int
    {
        return socket_write($this->socket, $message, strlen($message));
    }


    public function close(): void
    {
        socket_close($this->socket);
    }
}
