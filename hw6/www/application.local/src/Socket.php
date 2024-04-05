<?php

declare(strict_types=1);

namespace App;

class Socket
{
    protected \Socket $socket;
    private string $path;
    const BACKLOG_SIZE = 5;
    const MAX_SIZE_MESSAGE = 2048;

    public function __construct($path)
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        $this->path = $path;
    }

    public function read()
    {
        $result = socket_read($this->socket, 2048);

        if ($result === false) {
            $error = socket_last_error();
            echo "Socket read error: " . socket_strerror($error);
            $this->close();
        }
        return $result;
    }

    public function write($data)
    {
        socket_write($this->socket, $data, strlen($data));
    }

    public function listen()
    {
        socket_listen($this->socket, self::BACKLOG_SIZE);
    }

    public function accept()
    {
        $_socket = socket_accept($this->socket);

        if ($_socket === false) {
            $error = socket_last_error();
            throw new \RuntimeException("Socket accept error: " . socket_strerror($error));
        }

        $this->socket = $_socket;
    }

    public function connect()
    {
        socket_connect($this->socket, $this->path);
    }

    public function bind()
    {
        socket_bind($this->socket, $this->path);
    }

    public function close()
    {
        socket_close($this->socket);
    }

    public function receive(): string
    {
        socket_recv($this->socket, $message, self::MAX_SIZE_MESSAGE, 0);
        return $message ?? '';
    }
}
