<?php
declare(strict_types=1);

namespace EEvstifeev\Chat;

use RuntimeException;
use Socket as BaseSocket;

final class Socket
{
    private ?BaseSocket $socket = null;
    private string $socketFile;

    /**
     * @throws RuntimeException
     */
    public function __construct(private readonly Config $config = new Config())
    {
        $this->socketFile = $this->config->get('path');
    }

    public function createSocket(bool $recreate = false): bool|BaseSocket
    {
        if ($recreate && file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        if ($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) {
            return $this->socket;
        }
        throw new RuntimeException('Не удалось создать сокет!');
    }

    public function bindSocket(?int $port = 0): bool
    {
        return socket_bind($this->socket, $this->socketFile, $port);
    }

    public function connectSocket(?int $port = 0): void
    {
        if (!isset($this->socket)) {
            throw new RuntimeException('Отсутствует сокет для подключения!');
        }
        if (!socket_connect($this->socket, $this->socketFile, $port)) {
            throw new RuntimeException('Не удалось подключить сокет!');
        }
    }

    public function writeSocket($message): void
    {
        if (!socket_write($this->socket, $message, strlen($message))) {
            throw new RuntimeException('Не удалось записать в сокет!');
        }
    }
}
