<?php

namespace Sherweb;

class Socket
{
    public $socket;
    public $host;

    public function __construct($host)
    {
        $this->socket = socket_create(1, SOCK_DGRAM, 0);
        if (!$this->socket) {
            die('Unable to create AF_UNIX socket');
        }
        $this->host = $host;
    }

    public function bind()
    {
        return socket_bind($this->socket, $this->host);
    }

    public function setBlock()
    {
        return socket_set_block($this->socket);
    }

    public function setNonBlock()
    {
        return socket_set_nonblock($this->socket);
    }

    public function getMessage()
    {
        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        return [
            'bytes_received' =>  $bytes_received,
            'from' => $from,
            'buf' => $buf,
        ];
    }

    public function sendMessage($message, $from)
    {
        $len = strlen($message);
        return socket_sendto($this->socket, $message, $len, 0, $from);
    }

    public function __destruct()
    {
        $this->clear();
    }

    public function clear()
    {
        socket_close($this->socket);
        if ($this->host) {
            @unlink($this->host);
        }
    }
}