<?php

declare(strict_types=1);

namespace Art\Php2023\Helpers;

class ResponseFormation
{
    public static function makeResponse(mixed $textResponse, int $code)
    {
        return header("HTTP/1.1 " . $code . " " . $textResponse);
    }
}
