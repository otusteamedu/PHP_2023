<?php

namespace Exceptions;

use Exception;

class FirstBracketException extends Exception
{
    public function __construct()
    {
        parent::__construct("First bracket must be Opened!", 400);
    }
}