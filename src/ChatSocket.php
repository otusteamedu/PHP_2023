<?php

declare(strict_types=1);

namespace App;

use RuntimeException;
use Socket;

class ChatSocket
{
    private Socket $socket;
    private string $socketFile;
    private int $maxBytes;

    public function __construct()
    {
        if (!$config = parse_ini_file('config/config.ini')) {
            throw new RuntimeException('Не найден файл конфига');
        }

        if (!isset($config['path']) || !isset($config['max_bytes'])) {
            throw new RuntimeException('Не найдены переменные конфигурации');
        }

        $this->socketFile = $config['path'];
        $this->maxBytes = (int)$config['max_bytes'];
    }

    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    public function bind(): void
    {
        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        socket_bind($this->socket, $this->socketFile);
    }

    public function accept()
    {
        return socket_accept($this->socket);
    }

    public function connect(): void
    {
        if (!socket_connect($this->socket, $this->socketFile)) {
            throw new RuntimeException('Нет соединения с сокетом');
        }
    }

    public function send(string $message, $socket = null): void
    {
        $socket = $socket ?? $this->socket;
        if (!socket_write($socket, $message, strlen($message))) {
            throw new RuntimeException('Не удалось отправить сообщение');
        }
    }

    public function read(): string
    {
        return socket_read($this->socket, $this->maxBytes);
    }

    public function listen(): void
    {
        if (!socket_listen($this->socket)) {
            throw new RuntimeException('Не удалось установить режим чтения');
        }
    }

    public function receive(Socket $socket): array
    {
        $bytes_received = socket_recv($socket, $data, $this->maxBytes, 0);
        return [$data, (string)$bytes_received];
    }
}
