<?php

namespace Ndybnov\Hw06\exceptions;

class KeyRuleUsedRuntimeException extends \RuntimeException
{
    public function __construct(string $string)
    {
        parent::__construct($string);
    }
}
