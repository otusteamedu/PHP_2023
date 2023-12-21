<?php

declare(strict_types=1);

namespace Dshevchenko\Brownchat;

class SocketServer extends Socket
{
    private $client;

    public function __destruct()
    {
        $this->close();
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }
    }

    public function create(): bool
    {
        $this->client = null;

        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        if (!socket_bind($this->socket, $this->socketPath)) {
            return false;
        } elseif (!socket_listen($this->socket)) {
            return false;
        }

        return true;
    }

    public function accept(): bool
    {
        $result = socket_accept($this->socket);
        if ($result !== false) {
            $this->client = $result;
            return true;
        } else {
            return false;
        }
    }

    public function drop(): void
    {
        socket_close($this->client);
        $this->client = null;
    }

    public function read(): string
    {
        $result = socket_read($this->client, $this->bufferSize);
        if ($result === false) {
            return '';
        } else {
            return $result;
        }
    }

    public function write(string $message): void
    {
        $msgLen = strlen($message);
        socket_write($this->client, $message, $msgLen);
    }
}
