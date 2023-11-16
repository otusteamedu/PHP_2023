<?php

namespace src\exception;

use RuntimeException;
use Throwable;

class NotExistEventException extends RuntimeException
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = $message ?
            'NotExistEventException -> The event `' . $message . '` not found!' :
            'NotExistEventException';
        parent::__construct($message, $code, $previous);
    }
}
