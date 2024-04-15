<?php

declare(strict_types=1);

namespace Singurix\Chat;

use Exception;

class SocketChat
{

    public \Socket $socket;
    private string $socket_file;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $configFile = '/app/config.ini';
        $config = parse_ini_file($configFile, true);
        $this->socket_file = $config['socket']['file'];
    }

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

    public function listen(): self
    {
        if (!socket_listen($this->socket, 1)) {
            throw new Exception(socket_strerror(socket_last_error()) . "\n");
        }
        return $this;
    }

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

    public function isServerRun(): self
    {
        if (!file_exists($this->socket_file)) {
            throw new Exception('server not running' . "\n");
        }
        return $this;
    }
}
