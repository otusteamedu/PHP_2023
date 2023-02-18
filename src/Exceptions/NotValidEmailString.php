<?php

declare(strict_types=1);

namespace Twent\EmailValidator\Exceptions;

use Exception;
use Throwable;

final class NotValidEmailString extends Exception
{
    public function __construct(string $message = "", int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = "Неверный формат email: {$message}";
    }
}
