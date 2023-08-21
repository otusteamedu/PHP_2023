<?php

namespace Ndybnov\Hw04\hw\exceptions;

class ErrorInParameterException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Error in parameter!', $code = 0, $previous = null);
    }
}
