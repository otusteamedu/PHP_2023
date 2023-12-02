<?php

declare(strict_types=1);

namespace Otus;

use Exception;
use Otus\Framework\Core\Email;
use Otus\Framework\Http\Request;

class App
{
    public function run(): void
    {
        header('Content-Type: text/plain; charset=utf-8');
        try {
            $request = new Request();
            Email::validate($request);
            http_response_code(200);
            echo 'Emails have been successfully verified';
        } catch (Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }
}
