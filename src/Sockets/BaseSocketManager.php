<?php

declare(strict_types=1);

namespace Twent\Chat\Sockets;

use Socket;
use Twent\Chat\Sockets\Contracts\SocketManagerContract;

abstract class BaseSocketManager extends BaseSocketClient implements SocketManagerContract
{
    protected readonly ?UnixSocketConfig $config;

    public function __construct()
    {
        parent::__construct();
        $this->bind();
        socket_set_nonblock($this->getSocket());
        $this->listen();
        echo 'Сервер запущен...' . PHP_EOL;
    }

    public function read(?Socket $socket = null): ?string
    {
        $result = socket_read(! $socket ? $this->getSocket() : $socket, 100000);

        $this->throwIfFalse($result);

        return $result;
    }

    public function write(string $data, ?Socket $socket = null): ?int
    {
        $result = socket_write(! $socket ? $this->getSocket() : $socket, $data, strlen($data));

        $this->throwIfFalse($result);

        return $result;
    }

    /**
     * @throws UnixSocketError
     */
    public function select(array &$read): ?int
    {
        [$write , $except] = null;
        $result = socket_select($read, $write, $except, null);

        $this->throwIfFalse($result);

        return $result;
    }

    /**
     * @throws UnixSocketError
     */
    public function accept(): ?Socket
    {
        $result = socket_accept($this->getSocket());

        $this->throwIfFalse($result);

        return $result;
    }

    public function close(?Socket $socket = null): void
    {
        if (! $socket) {
            socket_close($this->getSocket());
            exit;
        }

        socket_close($socket);
    }

    /**
     * @throws UnixSocketError
     */
    protected function bind(): void
    {
        $unixSocket = new UnixSocket($this->config->get('socket_path'));

        $result = socket_bind($this->getSocket(), (string) $unixSocket);

        $this->throwIfFalse($result);
    }

    /**
     * @throws UnixSocketError
     */
    protected function listen(): bool
    {
        $result = socket_listen($this->getSocket(), intval($this->config->get('max_clients')));

        $this->throwIfFalse($result);

        return $result;
    }
}
