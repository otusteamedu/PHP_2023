<?php

declare(strict_types=1);

namespace Chat;

use Exception;
use Socket;

class Chat
{
    private string $file;
    private int $maxLength;

    private Socket $socket;
    public array $clipboard;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $config = parse_ini_file(__DIR__ . '/../config/config.ini', true);
        if (empty($config)) {
            throw new Exception("Empty config");
        }

        if (empty($config['socket']['file'])) {
            throw new Exception("Empty path socket");
        }
        $this->file = $config['socket']['file'];

        if (empty($config['chat']['max_length'])) {
            throw new Exception("Empty max length message");
        }
        $this->maxLength = (int)$config['chat']['max_length'];
    }

    /**
     * @throws Exception
     */
    public function create(): void
    {
        $result = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($result === false) {
            $lastError = socket_last_error();
            $errorMessage = socket_strerror($lastError);
            throw new Exception("Failed to create socket! Reason: $errorMessage" . PHP_EOL);
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
            $lastError = socket_last_error($this->socket);
            $errorMessage = socket_strerror($lastError);
            throw new Exception("Failed to connect socket! Reason: $errorMessage" . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        if (socket_listen($this->socket, 5) === false) {
            $lastError = socket_last_error($this->socket);
            $errorMessage = socket_strerror($lastError);
            throw new Exception("Failed to listen socket! Reason: $errorMessage" . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    public function accept(): void
    {
        $message = @socket_accept($this->socket);
        if ($message === false) {
            $lastError = socket_last_error($this->socket);
            $errorMessage = socket_strerror($lastError);
            throw new Exception("Failed to accept socket. Reason: $errorMessage" . PHP_EOL);
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
            $lastError = socket_last_error($this->socket);
            $errorMessage = socket_strerror($lastError);
            throw new Exception("Failed to connect socket. Reason: $errorMessage" . PHP_EOL);
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
            $lastError = socket_last_error($this->socket);
            $errorMessage = socket_strerror($lastError);
            throw new Exception("Failed to write socket. Reason: $errorMessage" . PHP_EOL);
        }
    }

    /**
     * @throws Exception
     */
    public function read(): void
    {
        $message = socket_read($this->socket, $this->maxLength);
        if ($message === false) {
            $lastError = socket_last_error($this->socket);
            $errorMessage = socket_strerror($lastError);
            throw new Exception("Failed to read socket. Reason: $errorMessage" . PHP_EOL);
        }

        $this->clipboard = ['message' => $message ];
    }

    public function receive(): void
    {
        $length = socket_recv($this->socket, $message, $this->maxLength, 0);
        $this->clipboard = ['message' => $message, 'length' => $length];
    }

    public function close(): void
    {
        socket_close($this->socket);
    }
}
