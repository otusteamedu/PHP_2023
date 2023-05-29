<?php

declare(strict_types=1);

namespace Art\Php2023\Socket;

use Socket as PhpSocket;

class SocketClient
{
    private Socket $socket;

    public string $exitCommand = '';

    public function __construct($config)
    {
        $this->socket      = new Socket($config);
        $this->exitCommand = $this->socket->exitCommand;
    }

    public function create(): bool|PhpSocket
    {
        return $this->socket->create();
    }

    public function connect()
    {
        $this->socket->connect();
    }

    public function write($message, $socket = null)
    {
        $this->socket->write($message, $socket);
    }

    public function read($socket = null)
    {
        return $this->socket->read($socket);
    }

    public function close($socket = null): void
    {
        $this->socket->close($socket);
    }
}
