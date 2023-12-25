<?php
declare(strict_types=1);

namespace Egorpotopakhin\Emailvalidator;

class App {
    public  static  function run(): string {

        $emailValidator = new EmailValidator();

        if (isset($_POST["input_email"])) {
            $input_email = $_POST["input_email"];
            if ($emailValidator->validate($input_email)) {
                http_response_code(200);
                return ("Все хорошо");
            } else {
                http_response_code(400);
                return ("Не прошла валидация");
            }
        } else {
            http_response_code(500);
            return ("Не найден запрос");
        }
    }
}