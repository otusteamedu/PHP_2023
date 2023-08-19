<?php

declare(strict_types=1);

namespace App\Hw4;

class Result
{
    public static function result(bool $result): string
    {
        if (!$result) {
            http_response_code(400);
            return 'Запрос не выполнен. Ошибка валидации';
        }

        http_response_code(200);
        return 'Запрос выполнен успешно';
    }
}
