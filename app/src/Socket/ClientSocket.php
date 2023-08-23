<?php


namespace Jasur\App\Socket;


class ClientSocket
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

    public function read($socket)
    {
        return $this->socket->read($socket);
    }

    public function close($socket = null)
    {
        $this->socket->close($socket);
    }
}