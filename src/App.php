<?php

declare(strict_types=1);

namespace Twent\BracketsValidator;

use Exception;

final class App
{
    public static function getValidationResult(): string
    {
        if (!$_REQUEST['string']) {
            http_response_code(400);
            return 'Не передан параметр string';
        }

        try {
            Validator::run($_REQUEST['string']);
            http_response_code(200);
            return 'Строка корректна';
        } catch (Exception $e) {
            http_response_code(400);
            return $e->getMessage();
        }
    }
}
