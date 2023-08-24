<?php

namespace Exceptions;

class MissingArgumentException extends \Exception
{
    public function __construct(string $message = "You must provide all required arguments")
    {
        parent::__construct($message, 400);
    }
}
