<?php

namespace Dimal\Hw6\Application;

class Client
{
    private string $socket_path = '';
    private $socket;

    public function __construct(string $socket)
    {
        $this->socket_path = $socket;
        $this->createSocket();
    }

    private function createSocket()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        socket_set_nonblock($this->socket);
    }

    public function sendMsg(string $msg)
    {
        $snd = socket_sendto($this->socket, $msg, strlen($msg), 0, $this->socket_path);
        echo "SENDED BYTES: $snd\n";
    }
}
