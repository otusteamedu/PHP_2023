<?php

namespace src\infrastructure\repository\exception;

use RuntimeException;
use Throwable;

class UnableToExecuteStatementDBException extends RuntimeException
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = $message ?
            'UnableToExecuteStatementDBException -> `' . $message . '`.' :
            'UnableToExecuteStatementDBException';
        parent::__construct($message, $code, $previous);
    }
}
