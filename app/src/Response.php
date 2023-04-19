<?php

namespace Yakovgulyuta\Hw5;

class Response
{

    public function sendResponse(int $code, string $message): void
    {
        http_response_code($code);
        echo $message;
    }
}
