<?php

declare(strict_types=1);

namespace Imitronov\Hw7\Component;

use Imitronov\Hw7\Exception\SocketException;

final class Socket
{
    private \Socket $socket;

    /**
     * @throws SocketException
     */
    private function __construct(?\Socket $socket = null)
    {
        if (null === $socket) {
            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        }

        if (!$socket instanceof \Socket) {
            throw new SocketException('Could not create socket.');
        }

        $this->socket = $socket;
    }

    public static function create(): self
    {
        return new self();
    }

    /**
     * @throws SocketException
     */
    public function bind(string $host): void
    {
        if (!socket_bind($this->socket, $host)) {
            throw new SocketException('Could not bind socket.');
        }
    }

    /**
     * @throws SocketException
     */
    public function connect(string $host): void
    {
        if (!socket_connect($this->socket, $host)) {
            throw new SocketException('Could not connect to socket.');
        }
    }

    /**
     * @throws SocketException
     */
    public function listen(int $backlog): void
    {
        if (!socket_listen($this->socket, $backlog)) {
            throw new SocketException('Could not listen socket.');
        }
    }

    /**
     * @throws SocketException
     */
    public function accept(): Socket
    {
        $socket = socket_accept($this->socket);

        if (!$socket instanceof \Socket) {
            throw new SocketException('Could not accept socket.');
        }

        return new self($socket);
    }

    /**
     * @throws SocketException
     */
    public function read(int $length = 65536): string
    {
        $result = socket_read($this->socket, $length);

        if (false === $result) {
            throw new SocketException('Could not read from socket.');
        }

        return $result;
    }

    /**
     * @throws SocketException
     */
    public function write(string $message): int
    {
        $result = socket_write($this->socket, $message, strlen($message));

        if (false === $result) {
            throw new SocketException('Could not write to socket.');
        }

        return $result;
    }

    public function close(): void
    {
        socket_close($this->socket);
    }
}
