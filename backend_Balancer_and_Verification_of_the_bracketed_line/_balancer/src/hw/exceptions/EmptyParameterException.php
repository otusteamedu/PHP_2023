<?php

namespace Ndybnov\Hw04\hw\exceptions;

class EmptyParameterException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Parameter can not be empty!', $code = 0, $previous = null);
    }
}