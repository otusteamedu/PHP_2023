<?php

declare(strict_types=1);

namespace Dshevchenko\Brownchat;

abstract class Socket
{
    protected string $socketPath;
    protected object $socket;
    protected int $bufferSize;

    public function __construct(array $settings)
    {
        $this->socketPath = $settings['SOCKET'] ?? '/tmp/brownchat.sock';
        $this->bufferSize = (int)$settings['BUFFER'] ?? 1024;
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new \Exception('Cannot create socket');
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    abstract public function read(): ?string;

    abstract public function write(string $message): void;

    public function close(): void
    {
        if (isset($this->socket)) {
            socket_close($this->socket);
            unset($this->socket);
        }
    }
}
