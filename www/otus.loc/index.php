<?php

use Sherweb\BracketValidateApp;
use Sherweb\Core\Request;

require __DIR__ . '/vendor/autoload.php';

if ((new BracketValidateApp())->run()) {
    Request::setStatus("HTTP/1.1 200 OK");
    echo 'Все хорошо';
} else {
    Request::setStatus("HTTP/1.1 400 Bad Request");
    echo 'Все плохо';
}

