<?php

declare(strict_types=1);

namespace Otus\SocketChat\Exception\Socket;

use RuntimeException;

class SocketAcceptException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct("failed to accept a connection on a socket: $message");
    }
}