<?php

namespace Anna\Chat;

use Exception;

abstract class Socket
{
    public $socket;
    public string $host = 'chat.sock';

    /**
     * @throws Exception
     */
    public function createSocket()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket === false) {
            throw new Exception('Unable create socket.');
        }
    }
}
