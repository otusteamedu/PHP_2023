<?php

namespace app;

require_once 'JSONMessages.php';
require_once 'Validator.php';

class App
{
    public function run(): void
    {
        header('Content-type: application/json');

        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            if (Validator::validateEmail(trim($email))) {
                http_response_code(200);
                echo JSONMessages::setMessage("Email прошел валидацию");
            } else {
                http_response_code(400);
                echo JSONMessages::setMessage("Email не прошел валидацию");
            }
        } else {
            http_response_code(406);
            echo JSONMessages::setMessage("Неверные входные данные");
        }
    }
}
