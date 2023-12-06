<?php

declare(strict_types=1);

namespace Myklon\Hw5;

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
            http_response_code(200);
            echo 'Is valid.';
        } catch (\Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }
}
