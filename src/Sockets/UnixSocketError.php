<?php

declare(strict_types=1);

namespace Twent\Chat\Sockets;

use Exception;
use Throwable;

final class UnixSocketError extends Exception
{
    protected $code = 400;

    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = "Ошибка сокета: {$this->message}\n";
    }
}
