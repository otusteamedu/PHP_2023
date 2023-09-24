<?php

declare(strict_types=1);

namespace Eevstifeev\Chat\Socket;

use Eevstifeev\Chat\Config;
use Eevstifeev\Chat\Contracts\SocketContract;
use RuntimeException;
use Socket as BaseSocket;

class MainSocket implements SocketContract
{
    const MAX_LENGTH_FOR_READ = 1024;
    private ?BaseSocket $socket = null;
    private string $socketFile;
    public int $maxLengthForRead;

    public function __construct(readonly Config $config)
    {
        $this->socketFile = $this->config->get('path');
        $this->maxLengthForRead = intval($this->config->get('socket_max_bytes'));
    }

    public function handle(): void
    {
    }

    public function createSocket(bool $recreate = false): void
    {
        if ($recreate && file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new RuntimeException('Не удалось создать сокет!');
        }
    }

    public function bindSocket(?int $port = 0): void
    {
        if (!socket_bind($this->socket, $this->socketFile, $port)) {
            throw new RuntimeException('Не удалось привязать сокет!');
        }
    }

    public function acceptSocket(): BaseSocket
    {
        if ($this->socket === null) {
            throw new RuntimeException('Сокет не создан!');
        }
        $clientSocket = socket_accept($this->socket);

        if (!$clientSocket) {
            throw new RuntimeException('Ошибка при принятии сокета!');
        }

        $socketType = socket_get_option($clientSocket, SOL_SOCKET, SO_TYPE);
        if ($socketType !== SOCK_STREAM) {
            throw new RuntimeException('Неверный тип сокета!');
        }

        return $clientSocket;
    }

    public function connectSocket(): void
    {
        if (!isset($this->socket)) {
            throw new RuntimeException('Отсутствует сокет для подключения!');
        }
        if (!socket_connect($this->socket, $this->socketFile)) {
            throw new RuntimeException('Не удалось подключить сокет!');
        }
    }

    public function readSocket(): string
    {
        $data = socket_read($this->socket, self::MAX_LENGTH_FOR_READ);
        if ($data === false) {
            throw new RuntimeException('Ошибка при чтении из сокета!');
        }
        return $data;
    }

    public function writeSocket(string $message, $socket = null): void
    {
        $socket = $socket ?? $this->socket;
        if (!socket_write($socket, $message, strlen($message))) {
            echo 'Fatal error: #' . socket_last_error() . '. ' . socket_strerror(socket_last_error()) . PHP_EOL;
            throw new RuntimeException('Не удалось записать в сокет!');
        }
    }

    public function listenSocket(): void
    {
        if (!socket_listen($this->socket)) {
            throw new RuntimeException('Не удалось установить сокет в режим прослушивания!');
        }
    }

    public function receiveFromSocket($socket): string
    {
        socket_recv($socket, $message, $this->maxLengthForRead, 0);
        return $message;
    }
}
