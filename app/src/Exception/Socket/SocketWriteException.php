<?php

declare(strict_types=1);

namespace Otus\SocketChat\Exception\Socket;

use RuntimeException;

class SocketWriteException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct("failed to write to socket: $message");
    }
}