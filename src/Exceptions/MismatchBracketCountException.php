<?php

namespace Exceptions;

use Exception;

class MismatchBracketCountException extends Exception
{
    public function __construct()
    {
        parent::__construct("Mismatch bracket count!", 400);
    }
}
