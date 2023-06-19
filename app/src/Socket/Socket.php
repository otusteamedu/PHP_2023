<?php

declare(strict_types=1);

namespace Lebedevvr\Chat\Socket;

use RuntimeException;
use Socket as BaseSocket;

final class Socket
{
    private ?BaseSocket $socket = null;
    private string $socketFile;
    private int $maxBytes;

    /**
     * @throws RuntimeException
     */
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

    public function create(bool $recreate = false): bool|BaseSocket
    {
        if ($recreate && file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        if ($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) {
            return $this->socket;
        }

        throw new RuntimeException('Socket cannot be created!');
    }

    /**
     * @return false|resource|BaseSocket
     */
    public function accept()
    {
        return socket_accept($this->socket);
    }

    public function bind(?int $port = 0): bool
    {
        return socket_bind($this->socket, $this->socketFile, $port);
    }

    public function connect(?int $port = 0): void
    {
        if (!isset($this->socket)) {
            throw new RuntimeException('There is no socket to connect!');
        }
        if (!socket_connect($this->socket, $this->socketFile, $port)) {
            throw new RuntimeException('Socket cannot be connected!');
        }
    }

    /**
     * @throws RuntimeException
     */
    public function write($message): void
    {
        if (!socket_write($this->socket, $message, strlen($message))) {
            throw new RuntimeException('Cannot write to the socket!');
        }
    }
}