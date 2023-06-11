<?php

namespace App\Transport\Socket;

use Socket as SocketNative;

class Socket implements SocketInterface
{
    private false|SocketNative $socket;

    private string $pathToSocketFile;

    protected int $maxBytes;

    public function __construct(string $pathToSocketFile, int $maxBytes)
    {
        $this->pathToSocketFile = $pathToSocketFile;
        $this->maxBytes = $maxBytes;
    }

    public function create(bool $reWriteFile = false): static
    {
        if ($reWriteFile && file_exists($this->pathToSocketFile)) {
            unlink($this->pathToSocketFile);
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
        socket_connect($this->socket, $this->pathToSocketFile);
        return $this;
    }

    public function listen(int $backlog = 1): static
    {
        socket_listen($this->socket, $backlog);
        return $this;
    }

    public function accept(): SocketNative|false
    {
        return socket_accept($this->socket);
    }

    public function write(string $message, int $length = null): int|false
    {
        return socket_write($this->socket, $message, $length);
    }

    public function send(SocketNative $socket, string $message, int $length = null): int|false
    {
        return socket_write($socket,  $message,  $length);
    }

    public function read(): string
    {
        return socket_read($this->socket, $this->maxBytes);
    }

    public function recv(SocketNative|Socket $socket): string|null
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