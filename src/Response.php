<?php

declare(strict_types=1);

namespace Dmitryesaulenko\Php2023;

class Response
{
    const ERROR_EMPTY_REQUEST = 'Wrong request';
    const ERROR_REGEXP = 'No valid mail';
    const ERROR_DNS = 'Check DNS failed';

    const EMPTY_REQUEST_STATUS = 400;

    public static function success(string $response): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo $response;
    }

    public static function error(\Exception $exception): void
    {
        http_response_code($exception->getCode());
        echo $exception->getMessage();
    }
}
