<?php

declare(strict_types=1);

namespace YuzyukRoman\Http;

class Response
{
    public static function sendResponse(int $status, string $message): void
    {
        http_response_code($status);
        echo $message;
    }

    public static function sendNotAllowed(): void
    {
        header('HTTP/1.1 405 Method Not Allowed');
        header('Allow: POST');
    }
}
