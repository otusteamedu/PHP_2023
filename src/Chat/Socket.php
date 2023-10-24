<?php

declare(strict_types=1);

namespace DKhalikov\Hw5\Chat;

use Generator;

abstract class Socket
{
    private string $file;

    private int $size;

    /** @var resource */
    private $socket;


    /**
     * @param string $file
     * @param int $size
     */
    public function __construct(string $file, int $size)
    {
        $this->file = $file;
        $this->size = $size;
    }

    /**
     * @return void
     */
    abstract protected function initSocket(): void;

    /**
     * @return Generator
     */
    abstract protected function processChat(): Generator;

    /**
     * @return void
     */
    public function consoleChat(): void
    {
        $this->initSocket();

        foreach ($this->processChat() as $chatMessage) {
            echo $chatMessage;
        }
    }

    /**
     * @param bool $fresh
     * @return void
     */
    protected function create(bool $fresh = false): void
    {
        if ($fresh && file_exists($this->file)) {
            unlink($this->file);
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    /**
     * @return void
     */
    protected function connect(): void
    {
        socket_connect($this->socket, $this->file);
    }

    /**
     * @return void
     */
    protected function bind(): void
    {
        socket_bind($this->socket, $this->file);
    }

    /**
     * @return void
     */
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
    protected function write(string $message, $socket = null): void
    {
        $socket = $socket ?? $this->socket;

        socket_write($socket, $message, strlen($message));
    }

    /**
     * @return false|string
     */
    protected function read(): false|string
    {
        return socket_read($this->socket, $this->size);
    }
}
