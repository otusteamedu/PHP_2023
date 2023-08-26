<?php

declare(strict_types=1);

namespace Gesparo\Hw\Socket;

class ClientSocket extends BaseSocket
{
    protected function create(string $pathToTheUnixFile): \Socket
    {
        if (($socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new SocketException(socket_strerror(socket_last_error($socket)), socket_last_error($socket));
        }

        if (socket_connect($socket, $pathToTheUnixFile, 0) === false) {
            throw new SocketException(socket_strerror(socket_last_error($socket)), socket_last_error($socket));
        }

        return $socket;
    }

    public function getMessageSocket(): MessageSocket
    {
        if ($this->socket === null) {
            throw new \RuntimeException('You must create socket before getting message socket');
        }

        if (socket_set_nonblock($this->socket) === false) {
            throw new SocketException(socket_strerror(socket_last_error($this->socket)), socket_last_error($this->socket));
        }

        return new MessageSocket($this->socket, true);
    }
}
