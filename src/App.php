<?php

declare(strict_types=1);

namespace Dmitryesaulenko\Php2023;

use Dmitryesaulenko\Php2023\Email;

class App
{

    public function exec(): void
    {
        try {
            header('Content-Type: application/json; charset=utf-8');
            echo Email::verify();
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            echo $e->getMessage();
        }
    }

}