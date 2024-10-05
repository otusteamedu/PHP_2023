<?php

declare(strict_types=1);

namespace Singurix\Chat;

use Exception;

class SocketChat
{
    private \Socket $socket;

    private bool|\Socket $connection;

    private string $socket_file;

    /**
     * @throws Exception
     */
    public function __construct(string $socket_file)
    {
        $this->socket_file = $socket_file;
    }

    /**
     * @throws Exception
     */
    public function startServer(): self
    {
        $this->create()->bind()->listen();
        socket_set_nonblock($this->socket);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function create(): self
    {
        if (!$this->socket = socket_create(AF_UNIX, SOCK_STREAM, IPPROTO_IP)) {
            throw new Exception(socket_strerror(socket_last_error()) . "\n");
        }
        return $this;
    }

    /**
     * @throws Exception
     */
    public function bind(): self
    {
        if (file_exists($this->socket_file)) {
            unlink($this->socket_file);
        }
        if (!socket_bind($this->socket, $this->socket_file)) {
            throw new Exception(socket_strerror(socket_last_error()) . "\n");
        }
        return $this;
    }

    /**
     * @throws Exception
     */
    public function listen(): self
    {
        if (!socket_listen($this->socket, 1)) {
            throw new Exception(socket_strerror(socket_last_error()) . "\n");
        }
        return $this;
    }

    /**
     * @throws Exception
     */
    public function connect(): self
    {
        if (!socket_connect($this->socket, $this->socket_file)) {
            throw new Exception(socket_strerror(socket_last_error()) . "\n");
        }
        return $this;
    }

    public function close(): void
    {
        socket_close($this->socket);
        unlink($this->socket_file);
    }

    /**
     * @throws Exception
     */
    public function isServerRun(): self
    {
        if (!file_exists($this->socket_file)) {
            throw new Exception('server not running' . "\n");
        }
        return $this;
    }

    public function write($consoleMessage, $isServer = false): void
    {
        $socket = $isServer ? $this->connection : $this->socket;
        socket_write($socket, $consoleMessage, strlen($consoleMessage));
    }

    public function read($isServer = false): bool|string
    {
        $socket = $isServer ? $this->connection : $this->socket;
        return socket_read($socket, 2048);
    }

    public function accept(): bool
    {
        return (bool)(($this->connection = socket_accept($this->socket)));
    }

    public function setNonBlock(): void
    {
        socket_set_nonblock($this->connection);
    }

    public function isConnected(): \Socket|bool
    {
        return $this->connection;
    }
}
