<?php

declare(strict_types=1);

namespace Chat;

use Exception;
use Socket;

class Chat
{
    private string $file;
    private int $maxSize;

    private Socket $socket;
    public array $buf;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $config = parse_ini_file(__DIR__ . '/../config/config.ini', true);
        if (empty($config)) {
            throw new Exception( "Empty config");
        }

        if (empty($config['socket']['file'])) {
            throw new Exception("Empty path socket");
        }
        $this->file = $config['socket']['file'];

        if (empty($config['socket']['max_size'])) {
            throw new Exception("Empty path socket");
        }
        $this->maxSize = (int)$config['socket']['max_size'];
    }

    /**
     * @throws Exception
     */
    public function create(): void
    {
        $result = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($result === false) {
            $errorMessage = socket_strerror(socket_last_error());
            throw new Exception("Failed to create a socket! Reason: $errorMessage" . PHP_EOL);
        }

        $this->socket = $result;
    }

    /**
     * @throws Exception
     */
    public function bind(): void
    {
        if (file_exists($this->file)) {
            unlink($this->file);
        }

        $isSocketConnect = socket_bind($this->socket, $this->file);
        if (!$isSocketConnect) {
            $errorMessage = socket_strerror(socket_last_error($this->socket));
            throw new Exception("Failed to connect a socket! Reason: $errorMessage" . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        if (socket_listen($this->socket, 5) === false) {
            $errorMessage = socket_strerror(socket_last_error($this->socket));
            throw new Exception("Failed to listen a socket! Reason: $errorMessage" . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    public function accept(): void
    {
        $message = @socket_accept($this->socket);
        if ($message === false) {
            $errorMessage = socket_strerror(socket_last_error($this->socket));
            throw new Exception("Failed to accept a socket. Reason: $errorMessage" . PHP_EOL);
        }

        $this->socket = $message;
    }

    /**
     * @throws Exception
     */
    public function connect(): void
    {
        $connection = socket_connect($this->socket, $this->file);
        if (!$connection) {
            $errorMessage = socket_strerror(socket_last_error($this->socket));
            throw new Exception("Failed to connect a socket. Reason: $errorMessage" . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    public function write(string $message): void
    {
        $length = strlen($message);
        $result = socket_write($this->socket, $message, $length);
        if ($result === false) {
            $errorMessage = socket_strerror(socket_last_error($this->socket));
            throw new Exception("Failed to write a socket. Reason: $errorMessage" . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    public function read(): void
    {
        $message = socket_read($this->socket, $this->maxSize);
        if ($message === false) {
            $errorMessage = socket_strerror(socket_last_error($this->socket));
            throw new Exception("Failed to read a socket. Reason: $errorMessage" . PHP_EOL);
        }

        $this->buf = ['message' => $message ];
    }

    public function receive(): void
    {
        $length = socket_recv($this->socket, $message, $this->maxSize, 0);
        $this->buf = ['message' => $message, 'length' => $length];
    }

    public function close(): void
    {
        socket_close($this->socket);
    }
}
