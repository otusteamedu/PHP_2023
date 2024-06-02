<?php

namespace Propan13\App\Chat;

use Exception;
use Generator;

abstract class Socket
{
    private \Socket $socket;
    
    abstract function init(): void;

    abstract function launch(): Generator;

    public function __construct()
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded');
        }
    }

    public function __invoke(): void
    {
        $this->init();
        foreach ($this->launch() as $message) {
            echo $message . PHP_EOL;
        }
    }

    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket === false) {
            throw new Exception('socket_create() failed: ' . socket_strerror(socket_last_error()));
        }
    }

    public function bind(bool $isNew = false): void
    {
        if ($isNew && file_exists($_ENV['CHAT_SOCKET_PATH'])) {
            unlink($_ENV['CHAT_SOCKET_PATH']);
        }

        if (!socket_bind($this->socket, $_ENV['CHAT_SOCKET_PATH'])) {
            throw new Exception('Could not bind to socket');
        }
    }

    public function listen(): void
    {
        $listen = socket_listen($this->socket,1);
        if ($listen === false) {
            throw new Exception('Could not listen on socket');
        }
    }

    public function accept()
    {
        $accept = socket_accept($this->socket);
        if ($accept === false) {
            throw new Exception('Could not accept socket');
        }
        return $accept;
    }

    public function connect(): void
    {
        $connect = socket_connect($this->socket, $_ENV['CHAT_SOCKET_PATH'], 0);
        if ($connect === false) {
            throw new Exception('Could not connect to socket');
        }
    }

    public function write(string $msg, $socket = null): void
    {
        if ($socket === null) {
            $socket = $this->socket;
        }
        $sent = socket_write($socket, $msg, strlen($msg));
        if ($sent === false) {
            throw new Exception('Could not write to socket');
        }
    }

    public function receive($socket): string
    {
        socket_recv($socket, $message, $_ENV['CHAT_SOCKET_LENGTH'], 0);
        return $message;
    }

    public function read(): false|string
    {
        return socket_read($this->socket, $_ENV['CHAT_SOCKET_LENGTH']);
    }
}