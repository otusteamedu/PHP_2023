<?php

declare(strict_types=1);

namespace Otus\SocketChat\Service;

use Otus\SocketChat\Exception\{Socket\BindSocketException,
    Socket\ReadFromSocketException,
    Socket\SocketAcceptException,
    Socket\SocketConnectException,
    Socket\SocketCreateException,
    Socket\SocketListenException,
    Socket\SocketWriteException};
use Socket;

class SocketService
{
    public function createSocket(): Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (false === $socket) {
            throw new SocketCreateException(socket_strerror(socket_last_error()));
        }

        return $socket;
    }

    public function bindSocketToFile(Socket $socket, string $file): void
    {
        if (false === socket_bind($socket, $file)) {
            throw new BindSocketException(socket_strerror(socket_last_error()));
        }
    }

    public function listenSocket(Socket $socket): void
    {
        $listen = socket_listen($socket);
        if (!$listen) {
            throw new SocketListenException(socket_strerror(socket_last_error()));
        }
    }

    public function acceptSocketConnection(Socket $socket): Socket
    {
        $connection = socket_accept($socket);
        if (!$connection) {
            throw new SocketAcceptException(socket_strerror(socket_last_error()));
        }

        return $connection;
    }

    public function readFromSocket(Socket $connection): string
    {
        $input = socket_read($connection, 1024);
        if (false === $input) {
            throw new ReadFromSocketException(socket_strerror(socket_last_error()));
        }

        return $input;
    }

    public function connectToSocket(Socket $socket, string $file): void
    {
        $connect = socket_connect($socket, $file);
        if (false === $connect) {
            throw new SocketConnectException(socket_strerror(socket_last_error()));
        }
    }

    public function writeToSocket(Socket $socket, string $message): void
    {
        $bytes = socket_write($socket, $message, strlen($message));
        if (false === $bytes) {
            throw new SocketWriteException(socket_strerror(socket_last_error()));
        }
    }
}