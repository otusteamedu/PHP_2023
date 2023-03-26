<?php

namespace Sva\App\Socket;

use Exception;
use Socket;

class Manager
{
    /**
     * @var Socket
     */
    private Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $socketFile = new File();
        $socketFile->deleteIfExists();

        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            throw new Exception("Unable to create socket: " . socket_strerror(socket_last_error()));
        }

        if (socket_bind($socket, $socketFile->getSocketPath()) === false) {
            throw new Exception("Unable to bind socket: " . "[" . socket_last_error() . "] " . socket_strerror(socket_last_error()));
        }

        if (socket_listen($socket) === false) {
            throw new Exception("Unable to listen on socket: " . socket_strerror(socket_last_error()));
        }

        $this->socket = $socket;
    }

    /**
     * @return Socket
     */
    public function getSocket(): Socket
    {
        return $this->socket;
    }

    /**
     * @throws Exception
     */
    public function acceptConnection(): Connection
    {
        return Connection::accept($this);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }
}
