<?php

declare(strict_types=1);

namespace Twent\EmailValidator\Exceptions;

use InvalidArgumentException;
use Throwable;

final class MxRecordNotExists extends InvalidArgumentException
{
    public function __construct(string $message = '', int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = "MX запись для адреса {$message} не найдена!";
    }
}
