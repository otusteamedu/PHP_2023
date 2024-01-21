<?php

namespace VladimirPetrov\EmailValidator\helpers;

use http\Client\Response;

class ResponseHelper
{

    /**
     * @return void
     */
    public static function successResponse()
    {
        http_response_code(200);
    }

    /**
     * @return void
     */
    public static function errorResponse()
    {
        http_response_code(400);
    }

    /**
     * @return void
     */
    public static function errorMethodResponse()
    {
        http_response_code(405);
    }
}
