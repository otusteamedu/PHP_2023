<?php

declare(strict_types=1);

namespace Kanakhin\WebSockets\Domain;

use Exception;
use Socket;

abstract class SocketEntity
{
    private string $socket_path;
    private int $io_buffer_size;
    private int $max_connections;
    private int $port;
    protected Socket|false $socket;

    /**
     * @param string $socket_host
     * @param int $io_buffer_size
     * @param int $max_connections
     */
    public function __construct(string $socket_host, int $io_buffer_size, int $max_connections, int $port)
    {
        $this->socket_path = $socket_host;
        $this->io_buffer_size = $io_buffer_size;
        $this->max_connections = $max_connections;
        $this->port = $port;
    }

    public abstract function start(ISocketReader $reader, ISocketWriter $writer): void;

    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            $message = 'Ошибка при создании сокета: ' . socket_strerror(socket_last_error());
            throw new Exception($message);
        }

        if ( ! socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1))
        {
            $message = 'Ошибка при установке опций сокета: ' . socket_strerror(socket_last_error());
            throw new Exception($message);
        }
    }

    public function connect(): void
    {
        socket_connect($this->socket, $this->socket_path, $this->port);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function accept(): Socket|false
    {
        return socket_accept($this->socket);
    }

    public function write(string $message, ?Socket $socket = null): void
    {
        socket_write($socket ?? $this->socket, $message, strlen($message));
    }

    public function read(?Socket $socket = null): string
    {
        socket_recv($socket ?? $this->socket, $message, $this->io_buffer_size, 0);
        return $message ?? '';
    }

    public function bind(): void
    {
        if (!socket_bind($this->socket, $this->socket_path, $this->port)) {
            $message = 'Не удалось привязать сокет по причине: ' . socket_strerror(socket_last_error());
            throw new Exception($message);
        }
    }

    public function listen(): void
    {
        if (!socket_listen($this->socket, $this->max_connections)) {
            $message = 'Не удалось привязать сокет по причине: ' . socket_strerror(socket_last_error());
            throw new Exception($message);
        }
    }
}