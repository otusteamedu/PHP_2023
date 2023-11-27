<?php

namespace App;

class App
{
    public function run(): string
    {
        header('Content-type: application/json');

        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            if (Validator::validateEmail(trim($email))) {
                http_response_code(200);
                return JSONMessages::setMessage("Email прошел валидацию");
            } else {
                http_response_code(400);
                return JSONMessages::setMessage("Email не прошел валидацию");
            }
        } else {
            http_response_code(406);
            return JSONMessages::setMessage("Неверные входные данные");
        }
    }
}
