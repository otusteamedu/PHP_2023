<?php

namespace WorkingCode\Hw6\Manager;

use Socket;
use WorkingCode\Hw6\Exception\SocketException;

class SocketManager
{
    private Socket $socket;

    public function __construct(private readonly string $socketPath)
    {
    }

    /**
     * @throws SocketException
     */
    public function serverInit(): void
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        $this->createSocket();

        if (!socket_bind($this->socket, $this->socketPath)) {
            throw new SocketException("socket_bind. {$this->getLastError()}");
        }

        if (!socket_listen($this->socket, 1)) {
            throw new SocketException("socket_listen. {$this->getLastError()}");
        }

        $socket = socket_accept($this->socket);

        if (!$socket) {
            throw new SocketException("socket_accept. {$this->getLastError()}");
        }

        $this->socket = $socket;
    }

    /**
     * @throws SocketException
     */
    private function createSocket(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$socket) {
            throw new SocketException("socket_create. {$this->getLastError()}");
        }

        $this->socket = $socket;
    }

    private function getLastError(): string
    {
        return socket_strerror(socket_last_error($this->socket));
    }

    /**
     * @throws SocketException
     */
    public function clientInit(): void
    {
        $this->createSocket();

        if (!socket_connect($this->socket, $this->socketPath)) {
            throw new SocketException("socket_connect. {$this->getLastError()}");
        }
    }

    public function sendMessage(string $message): void
    {
        socket_write($this->socket, $message, strlen($message));
    }

    /**
     * @throws SocketException
     */
    public function getMessage(): string
    {
        $message = socket_read($this->socket, 2048);

        if ($message === false) {
            throw new SocketException("socket_read. {$this->getLastError()}");
        }

        return trim($message);
    }

    public function closeSocket(): void
    {
        socket_close($this->socket);
    }
}
