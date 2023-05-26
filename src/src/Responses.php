<?php

declare(strict_types=1);

namespace nikitaglobal;

abstract class Responses
{
    public static function success()
    {
        http_response_code(200);
        return;
    }
    public static function error()
    {
        http_response_code(400);
        return;
    }
}
