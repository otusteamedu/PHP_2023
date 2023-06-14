<?php

declare(strict_types=1);

namespace Otus\App\Socket;

final class SocketManager
{
    public function create(): \Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, IPPROTO_IP);
        $this->checkError();

        return $socket;
    }

    public function connect(\Socket $socket, string $socketPath): void
    {
        socket_connect($socket, $socketPath);
        $this->checkError();
    }

    public function bind(\Socket $socket, $socketPath): void
    {
        socket_bind($socket, $socketPath);
        $this->checkError();
    }

    public function listen(\Socket $socket): void
    {
        socket_listen($socket);
        $this->checkError();
    }

    public function accept(\Socket $socket): \Socket
    {
        $socket = socket_accept($socket);
        $this->checkError();

        return $socket;
    }

    public function read(\Socket $socket): string
    {
        return socket_read($socket, 1024);
    }

    public function write(\Socket $socket, string $message): void
    {
        socket_write($socket, $message, strlen($message));
    }

    public function close(\Socket $socket): void
    {
        socket_close($socket);
    }

    private function checkError(): void
    {
        $error = socket_last_error();

        if ($error !== 0) {
            throw new \RuntimeException(sprintf('Socket error %s', socket_strerror($error)));
        }
    }
}