<?php

class EmptyBracketSequenceException extends Exception
{
    function __construct()
    {
        $this->message = "Пустая скобочная последовательность";
    }
}