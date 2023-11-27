<?php

declare(strict_types=1);

namespace Artyom\Php2023\helpers;

class ResponseHelper
{
    /**
     * @param string $message
     *
     * @return string
     */
    public static function successResponse(string $message): string
    {
        http_response_code(200);

        return $message;
    }

    /**
     * @param string $message
     *
     * @return string
     */
    public static function errorResponse(string $message): string
    {
        http_response_code(400);

        return $message;
    }
}
