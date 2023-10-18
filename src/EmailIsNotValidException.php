<?php

declare(strict_types=1);

namespace src;

use Exception;
use Throwable;

class EmailIsNotValidException extends Exception
{
    public function __construct(string $message = "Email is not valid", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
