<?php

declare(strict_types=1);

namespace Atsvetkov\Chat\Socket;

use RuntimeException;
use Socket as BaseSocket;

final class Socket
{
    private ?BaseSocket $socket = null;
    private string $socketFile;
    private int $maxBytes = 1024;

    public function __construct()
    {
        if (!$config = parse_ini_file(dirname(__DIR__, 2) . '/config/socket.ini', true)) {
            throw new RuntimeException('There is no socket configuration file!');
        }
        if (!isset($config['socket']['path'])) {
            throw new RuntimeException('There is no path variable in configuration file!');
        }
        if (!isset($config['socket']['max_bytes'])) {
            throw new RuntimeException('There is no max_bytes variable in configuration file!');
        }
        $this->socketFile = $config['socket']['path'];
        $this->maxBytes = intval($config['socket']['max_bytes']);
    }

    public function create(bool $recreate = false): void
    {
        if ($recreate && file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new RuntimeException('Socket cannot be created!');
        }
    }

    public function accept()
    {
        return socket_accept($this->socket);
    }

    public function bind(?int $port = 0): bool
    {
        return socket_bind($this->socket, $this->socketFile, $port);
    }

    public function connect(?int $port = null): void
    {
        if (!isset($this->socket)) {
            throw new RuntimeException('There is no socket to connect!');
        }
        if (!socket_connect($this->socket, $this->socketFile, $port)) {
            throw new RuntimeException('Socket cannot be connected!');
        }
    }

    public function read(): string
    {
        $data = socket_read($this->socket, $this->maxBytes);
        if ($data === false) {
            throw new RuntimeException('Cannot read from the socket!');
        }
        return $data;
    }

    public function write($message, $socket = null): void
    {
        $socket = $socket ?? $this->socket;
        if (!socket_write($socket, $message, strlen($message))) {
            throw new RuntimeException('Cannot write to the socket!');
        }
    }

    public function listen(): void
    {
        if (!socket_listen($this->socket)) {
            throw new RuntimeException('Cannot set listen mode on socket!');
        }
    }

    public function receive($socket): string
    {
        socket_recv($socket, $message, $this->maxBytes, 0);
        return $message;
    }
}