<?php

declare(strict_types=1);

namespace Controllers;

use Exception;
use Services\StringValidator;

class StringValidatorController
{
    public static function validate(): string
    {
        $value = $_REQUEST['email'];
        try {
            if (empty($value)) {
                throw new Exception("Строковый параметр пуст");
            }
            $stringValidator = new StringValidator();

            if (!$stringValidator->isValidString($value)) {
                throw new Exception("Ваша строка '$value' содержит недопустимые круглые скобки");
            }

            http_response_code(200);
            return "ОК: Ваша строка '$value' действительна";
        } catch (Exception $e) {
            http_response_code(400);
            return "плохой запрос: " . $e->getMessage();
        }
    }
}
