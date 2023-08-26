<?php

declare(strict_types=1);

namespace Gesparo\Hw\Socket;

class ServerSocket extends BaseSocket
{
    private string $pathToTheUnixFile;

    public function __construct(string $pathToTheUnixFile)
    {
        $this->pathToTheUnixFile = $pathToTheUnixFile;

        parent::__construct($pathToTheUnixFile);
    }

    protected function create(string $pathToTheUnixFile): \Socket
    {
        if (($socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new SocketException(socket_strerror(socket_last_error($socket)), socket_last_error($socket));
        }

        if (socket_bind($socket, $pathToTheUnixFile) === false) {
            throw new SocketException(socket_strerror(socket_last_error($socket)), socket_last_error($socket));
        }

        if (socket_listen($socket, 5) === false) {
            throw new SocketException(socket_strerror(socket_last_error($socket)), socket_last_error($socket));
        }

        return $socket;
    }

    public function getMessageSocket(): MessageSocket
    {
        if ($this->socket === null) {
            throw new \RuntimeException('You must create socket before getting message socket');
        }

        if (($messageSocket = socket_accept($this->socket)) === false) {
            throw new SocketException(socket_strerror(socket_last_error($this->socket)), socket_last_error($this->socket));
        }

        if (socket_set_nonblock($messageSocket) === false) {
            throw new SocketException(socket_strerror(socket_last_error($messageSocket)), socket_last_error($messageSocket));
        }

        return new MessageSocket($messageSocket);
    }

    public function __destruct()
    {
        parent::__destruct();

        if (file_exists($this->pathToTheUnixFile)) {
            unlink($this->pathToTheUnixFile);
        }
    }
}
