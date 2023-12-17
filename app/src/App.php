<?php

declare(strict_types=1);

namespace Myklon\Hw5;

use Myklon\Hw5\Services\RequestValidator;
use Myklon\Hw5\Services\EmailValidator;

class App
{
    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Method Not Allowed.';
            return;
        }

        try {
            RequestValidator::validate("emails");
            EmailValidator::validate();
            http_response_code(200);
            echo 'Emails is valid.';
        } catch (\Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }
}
