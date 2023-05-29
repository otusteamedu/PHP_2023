<?php

declare(strict_types=1);

namespace Art\Php2023\Socket;

use Socket as PhpSocket;

/**
 * Class for working with unix sockets
 * 
 */
class Socket
{
    public $socket;

    protected string $socketFile = '';

    protected int|string $maxBytes = 0;

    public string $exitCommand = 'exit';

    public function __construct(array $configs)
    {
        if (!$configs['path'] || !$configs['max_bytes']) {
            throw new \InvalidArgumentException('Error: Missing socket path or max_bytes in configs parameter');
        }

        $this->socketFile = $configs['path'];
        $this->maxBytes   = $configs['max_bytes'];
    }

    public function create(bool $removeSocketFile = false): bool|PhpSocket
    {
        if ($removeSocketFile && file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        if ($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) {
            return $this->socket;
        }

        throw new \RuntimeException('Error: Socket did not created.');
    }

    public function bind()
    {
        if (!socket_bind($this->socket, $this->socketFile)) {
            throw new \RuntimeException('Error: Cannot bind to socket.');
        }
    }

    public function listen()
    {
        if (!socket_listen($this->socket, 5)) {
            throw new \RuntimeException('Error: Cannot listen the socket.');
        }
    }

    public function connect()
    {
        if (!socket_connect($this->socket, $this->socketFile)) {
            throw new \RuntimeException('Error: Cannot connect to socket.');
        }
    }

    public function accept()
    {
        if ($socket = socket_accept($this->socket)) {
            return $socket;
        }

        throw new \RuntimeException('Error: Cannot accept connection to socket.');
    }

    public function write($message, $socket = null)
    {
        $socket = $socket ?: $this->socket;

        if (!socket_write($socket, $message, strlen($message))) {
            throw new \RuntimeException('Error: Cannot write to socket.');
        }
    }

    public function read($socket = null)
    {
        $socket = $socket ?: $this->socket;
        return socket_read($socket, (int) $this->maxBytes);
    }

    public function receive($socket): array
    {
        $buffer = '';
        $socket = $socket ?: $this->socket;

        if ($bytes = socket_recv($socket, $buffer, (int) $this->maxBytes, 0)) {
            return ['message' => $buffer, 'bytes' => $bytes];
        }

        throw new \RuntimeException('Error: Message could not be read');
    }

    public function close($socket = null): void
    {
        $socket = $socket ?: $this->socket;

        if (!$socket) {
            throw new \RuntimeException('Error: Missing socket for closing.');
        }

        socket_close($socket);
    }
}
