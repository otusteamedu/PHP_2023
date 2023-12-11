<?php

namespace Dimal\Hw6;

class Socket
{
    private string $socket_dir;
    private $socket;
    private ?string $from;

    public function __construct($socket_dir)
    {
        $this->socket_dir = $socket_dir;
    }

    public function createServerSocket(): bool
    {
        $socket_path = $this->socket_dir . '/server.sock';
        return $this->createSocket($socket_path);
    }

    public function createClientSocket(): bool
    {
        $socket_path = $this->socket_dir . '/client.sock';
        return $this->createSocket($socket_path);
    }

    private function createSocket($path): bool
    {
        if (file_exists($path)) {
            unlink($path);
        }

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        socket_bind($this->socket, $path);
        return true;
    }

    public function listen()
    {
        socket_recvfrom($this->socket, $msg, 1024, 0, $this->from);
        return $msg;
    }

    public function sendAnswer($msg)
    {
        $this->send($msg, $this->from);
    }

    public function sendToServer($msg)
    {
        $socket_path = $this->socket_dir . '/server.sock';
        $this->send($msg, $socket_path);
    }

    private function send($msg, $to)
    {
        socket_sendto($this->socket, $msg, strlen($msg), 0, $to);
    }
}
