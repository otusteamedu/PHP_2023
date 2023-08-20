<?php

namespace Ndybnov\Hw04\hw\exceptions;

class ErrorCountOfBracketsInParameterException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Error count of brackets in Parameter!', $code = 0, $previous = null);
    }
}
