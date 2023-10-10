<?php

declare(strict_types=1);

namespace Controllers;

use Exception;
use Models\StringValidator;

class StringController
{
    public static function validate(string $value): string
    {
        try {
            if (empty($value)) {
                throw new Exception("Параметр string пустой");
            }
            if (!(new StringValidator())->isValidString($value)) {
                throw new Exception("Строка $value содержит недопустимые круглые скобки");
            }
            http_response_code(200);
            return "Параметр string со значением $value валиден";
        } catch (Exception $e) {
            http_response_code(400);
            return $e->getMessage();
        }
    }
}
