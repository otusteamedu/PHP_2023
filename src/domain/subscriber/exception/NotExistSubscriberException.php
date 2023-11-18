<?php

namespace src\domain\subscriber\exception;

use RuntimeException;
use Throwable;

class NotExistSubscriberException extends RuntimeException
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = $message ?
            'NotExistSubscriberException -> The subscriber `' . $message . '` not found!' :
            'NotExistSubscriberException';
        parent::__construct($message, $code, $previous);
    }
}
