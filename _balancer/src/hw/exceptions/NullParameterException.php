<?php

namespace Ndybnov\Hw04\hw\exceptions;

class NullParameterException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Parameter can not be null!', $code = 0, $previous = null);
    }
}
