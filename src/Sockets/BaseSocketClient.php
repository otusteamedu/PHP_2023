<?php

declare(strict_types=1);

namespace Twent\Chat\Sockets;

use Socket;
use Twent\Chat\Sockets\Contracts\SocketClientContract;

abstract class BaseSocketClient implements SocketClientContract
{
    protected static ?self $instance = null;
    protected static ?Socket $socket = null;
    protected readonly ?UnixSocketConfig $config;

    public function __construct()
    {
        $this->config = new UnixSocketConfig();
    }

    public static function getInstance(): static
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @throws UnixSocketError
     */
    public function getSocket(): ?Socket
    {
        if (! static::$socket) {
            static::$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        }

        if (static::$socket === false) {
            throw new UnixSocketError($this->getErrorMessage());
        }

        return static::$socket;
    }

    /**
     * @throws UnixSocketError
     */
    public function connect(): ?bool
    {
        $result = socket_connect($this->getSocket(), $this->config->get('socket_path'));

        $this->throwIfFalse($result);

        return $result;
    }

    /**
     * @throws UnixSocketError
     */
    public function read(): ?string
    {
        $result = socket_read($this->getSocket(), 100000);

        $this->throwIfFalse($result);

        return $result;
    }

    /**
     * @throws UnixSocketError
     */
    public function write(string $data): ?int
    {
        $result = socket_write($this->getSocket(), $data, strlen($data));

        $this->throwIfFalse($result);

        return $result;
    }

    /**
     * @throws UnixSocketError
     */
    protected function throwIfFalse(mixed $result): void
    {
        if ($result === false) {
            throw new UnixSocketError($this->getErrorMessage());
        }
    }

    private function getErrorMessage(): string
    {
        return socket_strerror(socket_last_error());
    }
}
