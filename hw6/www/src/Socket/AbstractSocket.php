<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Socket;

abstract class AbstractSocket
{
    const SOCKET_FILE = '/var/run/php-cli/socket.sock';
    const READ_LENGTH = 1024;

    abstract public function run();

    protected function create(): \Socket|false
    {
        return socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    protected function write(\Socket $client, string $response): int|false
    {
        return socket_write($client, $response, strlen($response));
    }

    protected function read(\Socket $socket): string
    {
        return socket_read($socket, self::READ_LENGTH);
    }

    protected function close(\Socket $socket): void
    {
        socket_close($socket);
    }
}
