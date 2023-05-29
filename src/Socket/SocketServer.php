<?php

declare(strict_types=1);

namespace Art\Php2023\Socket;

use Socket as PhpSocket;

class SocketServer
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
        return $this->socket->create(true);
    }

    public function bind()
    {
        $this->socket->bind();
    }

    public function listen()
    {
        $this->socket->listen();
    }

    public function accept()
    {
        return $this->socket->accept();
    }

    public function write($message, $socket = null)
    {
        $this->socket->write($message, $socket);
    }

    public function receive($socket): array
    {
        return $this->socket->receive($socket);
    }

    public function close($socket = null): void
    {
        $this->socket->close($socket);
    }
}
