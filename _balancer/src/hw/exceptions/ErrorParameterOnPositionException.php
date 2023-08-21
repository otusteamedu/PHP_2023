<?php

namespace Ndybnov\Hw04\hw\exceptions;

class ErrorParameterOnPositionException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, $code = 0, $previous = null);
    }
}
