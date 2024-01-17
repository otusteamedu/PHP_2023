<?php

declare(strict_types=1);

namespace Santonov\Otus\Chat;

use Exception;
use Socket;

class Chat
{
    private const PATH_TO_CONFIG = __DIR__ . '/../../config/socket.ini';
    protected string $socketPath;
    protected int $maxConnections;
    protected int $maxLength;
    protected Socket|false $socket;
    public function __construct()
    {
        if (false === $config = parse_ini_file(self::PATH_TO_CONFIG)) {
            throw new \Exception('Failed to load socket config file');
        }
        $this->socketPath = $config['path'];
        $this->maxConnections = (int)$config['max_connections'];
        $this->maxLength = (int)$config['max_len'];
    }

    protected function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            $message = 'Failed to create socket ' . socket_strerror(socket_last_error());
            throw new Exception($message);
        }
    }

    protected function bind(): void
    {
        if (!socket_bind($this->socket, $this->socketPath)) {
            $message = 'Failed to bind socket ' . socket_strerror(socket_last_error());
            throw new Exception($message);
        }
    }

    protected function listen(): void
    {
        if (!socket_listen($this->socket, $this->maxConnections)) {
            $message = 'Failed to bind socket ' . socket_strerror(socket_last_error());
            throw new Exception($message);
        }
    }

    protected function connect(): void
    {
        socket_connect($this->socket, $this->socketPath);
    }

    protected function accept(): Socket|false
    {
        return socket_accept($this->socket);
    }

    public function read(?Socket $socket = null): string
    {
        socket_recv($socket ?? $this->socket, $message, $this->maxLength, 0);
        return $message ?? '';
    }

    public function write(string $message, ?Socket $socket = null): void
    {
        socket_write($socket ?? $this->socket, $message, strlen($message));
    }

    protected function close(): void
    {
        socket_close($this->socket);
    }
}
