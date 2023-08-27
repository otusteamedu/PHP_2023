<?php

declare(strict_types=1);

namespace Validate;

class StringValidator
{
    public static function validate(): void
    {
        if (isset($_POST['string'])) {
            $string = $_POST['string'];

            // 1. Проверка на пустоту
            if (empty($string)) {
                http_response_code(400);
                exit("Bad Request: Empty string");
            }

            // 2. Проверка на корректность кол-ва скобок
            $openBracketCount = substr_count($string, '(');
            $closeBracketCount = substr_count($string, ')');
            if ($openBracketCount != $closeBracketCount) {
                http_response_code(400);
                exit("Bad Request: Unmatched parenthesis count");
            }

            // 3. Проверка соответствия скобок
            $stack = [];
            for ($i = 0; $i < strlen($string); $i++) {
                $char = $string[$i];
                if ($char == '(') {
                    $stack[] = '(';
                } elseif ($char == ')') {
                    if (count($stack) == 0) {
                        http_response_code(400);
                        exit("Bad Request: Unmatched closing parenthesis");
                    }
                    array_pop($stack);
                }
            }

            if (count($stack) != 0) {
                http_response_code(400);
                exit("Bad Request: Unmatched opening parenthesis");
            }

            // Все проверки пройдены, возвращаем 200 OK
            http_response_code(200);
            echo "OK! Everything looks good!";
        } else {
            http_response_code(400);
            exit("Bad Request: 'string' parameter not found");
        }
    }
}
