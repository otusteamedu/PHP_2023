<?php

declare(strict_types=1);

namespace classes\Exception;

class HttpException extends \Exception
{
    public const CODE_400 = 400;
   
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
