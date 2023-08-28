<?php

declare(strict_types=1);

namespace Gesparo\Hw\Socket;

abstract class BaseSocket
{
    protected ?\Socket $socket = null;

    public function __construct(string $pathToTheUnixFile)
    {
        $this->socket = $this->create($pathToTheUnixFile);
    }

    abstract protected function create(string $pathToTheUnixFile): \Socket;
    abstract public function getMessageSocket(): MessageSocket;

    public function __destruct()
    {
        if ($this->socket !== null) {
            socket_shutdown($this->socket);
        }
    }
}
