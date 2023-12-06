<?php

namespace Dimal\Hw6\Application;

class Server
{
    private string $socket_path = '';
    private $socket;

    public function __construct(string $socket)
    {
        $this->socket_path = $socket;
    }

    public function __destruct()
    {
        if ($this->socket) {
            socket_close($this->socket);
        }

        if (file_exists($this->socket_path)) {
            unlink($this->socket_path);
        }
    }

    public function createSocket()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (file_exists($this->socket_path)) {
            unlink($this->socket_path);
        }

        socket_bind($this->socket, $this->socket_path);
    }

    public function observe()
    {
        while (true) {
            $msg = '';
            $from = '';
            socket_recvfrom($this->socket, $msg, 1024, 0, $from);
            echo "\nRECEIVED MSG: \"$msg\"";
        }
    }
}
