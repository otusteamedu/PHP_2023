<?php

namespace Artyom\Php2023\helpers;

class ResponseHelper
{
    /**
     * @param $message
     *
     * @return string
     */
    public static function successResponse($message): string
    {
        http_response_code(200);

        return $message;
    }

    /**
     * @param $message
     *
     * @return string
     */
    public static function errorResponse($message): string
    {
        http_response_code(400);

        return $message;
    }
}
