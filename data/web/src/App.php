<?php
declare(strict_types=1);

namespace src;
require_once 'BracketValidator.php';
class App {
    public  static  function run(): string {
        $bracketValidator = new BracketValidator();


        if (isset($_POST["input_brackets"])) {
            $input_brackets = $_POST["input_brackets"];
            if ($bracketValidator->validate($input_brackets)) {
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
