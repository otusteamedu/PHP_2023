<?php
declare(strict_types=1);

namespace Vasilaki;

class Socket
{
    private $socket;

    public function __construct($socketPath)
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_bind($this->socket, $socketPath);
        socket_listen($this->socket);
    }

    public function accept()
    {
        return socket_accept($this->socket);
    }

    public function read($clientSocket)
    {
        return socket_read($clientSocket, 1024);
    }

    public function write($clientSocket, $message)
    {
        socket_write($clientSocket, $message, strlen($message));
    }

    public function close()
    {
        socket_close($this->socket);
    }
}