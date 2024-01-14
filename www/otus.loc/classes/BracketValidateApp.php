<?php

namespace Sherweb;

use Sherweb\Core\Request;
use Sherweb\Validate\BracketsSymbols;

class BracketValidateApp
{
    /**
     * @return bool
     */
    public function run(): bool
    {
        if (Request::isPost() && BracketsSymbols::isValid($_POST["string"])) {
            Request::setStatus("HTTP/1.1 200 OK");
            echo "Всё хорошо";
        } else {
            Request::setStatus("HTTP/1.1 400 Bad Request");
            echo "Всё плохо";
        }

        return true;
    }
}