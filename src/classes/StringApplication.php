<?php

namespace Klobkovsky\App;

use Klobkovsky\App\ParenthesisValidator;

class StringApplication
{
    public function run()
    {
        $string = $_POST['string'];

        try {
            ParenthesisValidator::validate($string);

            http_response_code(200);
            return "Строка корректна";
        } catch (\Throwable $e) {
            http_response_code(400);
            return $e->getMessage();
        }
    }
}