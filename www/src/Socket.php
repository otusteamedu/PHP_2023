<?php

declare(strict_types=1);

namespace Yalanskiy\Chat;

use RuntimeException;

/**
 * Class to use sockets
 */
class Socket
{
    private mixed $conn;
    private mixed $socket;
    private string $socketPath;
    private int $socketMaxBytes;

    public function __construct()
    {
        $this->socketPath = Config::get('socket_path');
        $this->socketMaxBytes = (int)Config::get('socket_max_bytes');
    }

    /**
     * Server socket connection
     * @return void
     */
    public function create(): void
    {
        $this->conn = stream_socket_server('unix://' . $this->socketPath, $errorCode, $errorMessage);
        if ($this->conn === false) {
            throw new RuntimeException("Error socket creation: {$errorCode} ({$errorMessage})");
        }
    }

    /**
     * Client socket connection
     * @return void
     */
    public function connect(): void
    {
        $this->socket = stream_socket_client('unix://' . $this->socketPath, $errorCode, $errorMessage);

        if ($this->socket === false) {
            throw new RuntimeException("Error socket connection: {$errorCode} ({$errorMessage})");
        }
    }

    /**
     * Accept socket connection
     * @return mixed
     */
    public function accept(): mixed
    {
        return $this->socket = stream_socket_accept($this->conn, -1);
    }

    /**
     * Receive message from socket
     * @return string
     */
    public function receive(): string
    {
        return fread($this->socket, $this->socketMaxBytes);
    }

    /**
     * Send message to socket
     * @param $message
     *
     * @return void
     */
    public function send($message): void
    {
        fwrite($this->socket, $message);
    }

    /**
     * Close socket
     * @return void
     */
    public function close(): void
    {
        fclose($this->socket);
    }
}
