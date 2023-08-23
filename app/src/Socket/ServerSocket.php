<?php

namespace Jasur\App\Socket;


class ServerSocket
{

    private Socket $socket;

    public string $exitCommand = '';

    public function __construct($config)
    {
        $this->socket = new Socket($config);
        $this->exitCommand = $this->socket->exitCommand;
    }

    public function create()
    {
        return $this->socket->create(true);
    }

    public function bind()
    {
        return $this->socket->bind();
    }

    public function listen()
    {
        return $this->socket->listen();
    }

    public function accept()
    {
        return $this->socket->accept();
    }

    public function write($message, $socket = null)
    {
        return $this->socket->write($message, $socket);
    }

    public function receive($socket)
    {
        return $this->socket->receive($socket);
    }

    public function close($socket)
    {
        return $this->socket->close();
    }
}