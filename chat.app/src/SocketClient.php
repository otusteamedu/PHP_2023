<?php

declare(strict_types= 1);

namespace Dshevchenko\Brownchat;

class SocketClient extends Socket
{
    public function connect(): bool
    {
        return socket_connect($this->socket, $this->socketPath);
    }
    
    public function read(): string
    {
        $result = socket_read($this->socket, $this->bufferSize);    
        if ($result === false) {
            return '';
        }
        else {
            return $result;
        }
    }

    public function write(string $message): void
    {
        $msgLen = strlen($message);
        socket_write($this->socket, $message, $msgLen);
    }
}
