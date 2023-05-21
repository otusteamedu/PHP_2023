<?php

declare(strict_types=1);

namespace Girevik1\WebSerBalancer\Helpers;

class ResponseFormation
{
    public static function makeResponse(string | bool $textResponse, int $code)
    {
        if ($textResponse === true) {
            $textResponse = 'Все корректно!';
        }
        return header("HTTP/1.1 " . $code . " " . $textResponse);
    }
}
