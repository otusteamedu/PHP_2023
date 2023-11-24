<?php

declare(strict_types=1);

namespace Dimal\Homework4\Services;

use Exception;

class HttpCodeService
{
    private int $code = 0;
    private string $code_message = '';

    public function __construct(int $http_code)
    {
        switch ($http_code) {
            case 200:
                $this->code = 200;
                $this->code_message = 'OK';
                break;
            case 400:
                $this->code = 400;
                $this->code_message = 'Bad Request';
                break;
            default:
                throw new Exception("Unknown http code:" . $http_code);
                break;
        }
    }

    public function sendHttpCode($msg)
    {
        http_response_code($this->code);
        echo "$this->code $this->code_message. " . $msg;
    }
}
