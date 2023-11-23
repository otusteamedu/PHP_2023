<?php

namespace app;

require_once 'JSONMessages.php';
require_once 'Validator.php';

class App
{
    public function run(): void
    {
        header('Content-type: application/json');

        if (isset($_POST['string'])) {
            $str = $_POST['string'];

            if (Validator::validateBraces(trim($str))) {
                http_response_code(200);
                echo JSONMessages::setMessage("Все хорошо");
            } else {
                http_response_code(400);
                echo JSONMessages::setMessage("Скобка не прошла на соответствие");
            }
        } else {
            http_response_code(406);
            echo JSONMessages::setMessage("Неверные входные данные");
        }
    }
}