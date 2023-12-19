<?php

namespace WorkingCode\Hw4\Handler;

use WorkingCode\Hw4\Http\Response;

class ResponseHandler
{
    public function send(Response $response): void
    {
        http_response_code($response->getStatusCode());
        echo $response->getMessage();
    }
}
