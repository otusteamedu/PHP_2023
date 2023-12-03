<?php

declare(strict_types=1);

namespace Myklon\Hw4;

use Myklon\Hw4\Services\RequestValidator;
use Myklon\Hw4\Services\BracketValidator;

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
            RequestValidator::validate();
            BracketValidator::validate();
            http_response_code(200);
            echo 'Bracket sequence is valid.';
        } catch (\Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }
}