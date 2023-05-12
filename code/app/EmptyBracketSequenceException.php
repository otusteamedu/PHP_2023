<?php

namespace app;

use Exception;

class EmptyBracketSequenceException extends Exception
{
    public function __construct()
    {
        $this->message = "Пустая скобочная последовательность";
    }
}
