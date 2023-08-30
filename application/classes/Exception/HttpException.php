<?php

declare(strict_types=1);

namespace classes\Exception;

class HttpException extends \Exception
{
    public const CODE_400 = 400;
   
    public static function handleException(\Exception $exception)
    {
        header("HTTP/1.1 {$exception->getCode()} {$exception->getMessage()}");
        exit;
    }

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
