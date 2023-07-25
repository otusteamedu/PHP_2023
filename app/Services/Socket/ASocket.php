<?php

namespace App\Services\Socket;

use Socket;

abstract class ASocket
{
    private false|Socket $socket;

    private string $pathToSocketFile;

    protected int $maxBytes;

    public function __construct()
    {
        $this->pathToSocketFile = getenv('SOCKET_PATH');
        $this->maxBytes = getenv('SOCKET_SIZE');
    }

    public function create(bool $reWriteFile = false): static
    {
        if ($reWriteFile && file_exists($this->pathToSocketFile)) {
            unlink($this->maxBytes);
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        return $this;
    }

    public function bind(): static
    {
        socket_bind($this->socket, $this->pathToSocketFile, $this->maxBytes);
        return $this;
    }

    public function connect(): static
    {
        var_dump($this->pathToSocketFile);
        socket_connect($this->socket, $this->pathToSocketFile);
        return $this;
    }

    public function listen(int $backlog = 1): static
    {
        socket_listen($this->socket, $backlog);
        return $this;
    }

    public function accept(): Socket|false
    {
        return socket_accept($this->socket);
    }

    public function write(string $message, int $length = null): int|false
    {
        return socket_write($this->socket, $message, $length);
    }

    public function send(Socket $socket, string $message, int $length = null): int|false
    {
        return socket_write($socket, $message, $length);
    }

    public function read(): string
    {
        return socket_read($this->socket, $this->maxBytes);
    }

    public function recv(Socket|ASocket $socket): string|null
    {
        $res = "";
        socket_recv($socket, $res, $this->maxBytes, 0);
        return $res;
    }

    public function close(): static
    {
        socket_close($this->socket);
        return $this;
    }
}
