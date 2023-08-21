<?php

declare(strict_types=1);

namespace Gesparo\Hw\Exception;

class HttpException extends \Exception
{
    public const BAD_REQUEST_400 = 400;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
