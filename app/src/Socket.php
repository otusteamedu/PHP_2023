<?php

declare(strict_types=1);

namespace Agrechuha\Otus;

abstract class Socket
{
    private string $socketPath;
    private int $socketMaxBytes;
    private $socket;

    public function __construct()
    {
        $config               = parse_ini_file(__DIR__ . '/../config/main.ini', true);
        $this->socketPath     = $config['socket']['path'];
        $this->socketMaxBytes = (int)$config['socket']['socket_max_bytes'];
    }

    public function create($isServer = true): void
    {
        if ($isServer && file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        echo 'Сокет создан' . PHP_EOL;
    }

    /**
     * @return void
     */
    public function bind(): void
    {
        socket_bind($this->socket, $this->socketPath);
    }

    /**
     * @return void
     */
    public function listen(): void
    {
        socket_listen($this->socket);
    }

    /**
     * @return void
     */
    public function connect(): void
    {
        socket_connect($this->socket, $this->socketPath);
    }

    /**
     * @return false|resource
     */
    public function accept()
    {
        return socket_accept($this->socket);
    }

    /**
     * @param resource $socket
     */
    public function receive($socket): string
    {
        socket_recv($socket, $message, $this->socketMaxBytes, 0);

        return $message ?? '';
    }

    /**
     * @param string        $message
     * @param null|resource $socket
     */
    public function write(string $message, $socket = null): void
    {
        socket_write($socket ?? $this->socket, $message, strlen($message));
    }

    /**
     * @return void
     */
    public function close(): void
    {
        socket_close($this->socket);
    }

    abstract protected function initSocket();
}
