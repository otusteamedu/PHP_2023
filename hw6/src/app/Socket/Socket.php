<?php

declare(strict_types=1);

namespace AShashkov\ConsoleSocketChat\Socket;

use Exception;
use Generator;

class Socket
{
    private string $file;

    private int $size;

    /** @var resource */
    private $socket;

    private string $appPath;

    public function __construct()
    {
        $this->appPath = realpath(dirname(__DIR__));
        $this->initConfig();
    }

    public function consoleChat(): void
    {
        $this->initSocket();
        foreach ($this->processChat() as $chatMessage) {
            echo $chatMessage;
        }
    }

    private function initConfig(): void
    {
        if (file_exists($this->appPath . '/config/socket.ini')) {
            $configSettings = parse_ini_file($this->appPath . '/config/socket.ini');
        } else {
            throw new Exception('Config file for Sockets is missing or non-readable');
        }

        if (isset($configSettings['file']) && ! empty($configSettings['file'])) {
            $this->file = $configSettings['file'];
        }
        if (isset($configSettings['size']) && ! empty($configSettings['size'])) {
            $this->size = (int) $configSettings['size'];
        }
        if (! isset($this->file) || ! isset($this->size)) {
            throw new Exception('Config param is missing for socket file path or message size.');
        }
    }

    protected function create(bool $fresh = false): void
    {
        if ($fresh && file_exists($this->file)) {
            unlink($this->file);
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    protected function connect(): void
    {
        socket_connect($this->socket, $this->file);
    }

    protected function bind(): void
    {
        socket_bind($this->socket, $this->file);
    }

    protected function listen(): void
    {
        socket_listen($this->socket, 5);
    }

    /**
     * @return false|resource
     */
    protected function accept()
    {
        return socket_accept($this->socket);
    }

    /**
     * @param resource $socket
     */
    protected function receive($socket): array
    {
        $length = socket_recv($socket, $message, $this->size, 0);

        return ['message' => $message, 'length' => $length];
    }

    /**
     * @param string $message
     * @param null|resource $socket
     */
    protected function write(string $message, $socket = null)
    {
        $socket = $socket ?? $this->socket;

        socket_write($socket, $message, strlen($message));
    }

    protected function read(): false|string
    {
        return socket_read($this->socket, $this->size);
    }

    protected function initSocket(): void {}

    protected function processChat(): Generator {
        yield;
    }
}
