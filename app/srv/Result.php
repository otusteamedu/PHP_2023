<?php

declare(strict_types=1);

namespace App\Hw4;

class Result
{
    public static function result(bool $result): void
    {
        if ($result) {
            http_response_code(200);
            echo 'Запрос выполнен успешно';
        } else {
            http_response_code(400);
            echo 'Запрос невыполнен. Ошибка валидации';
        }
    }
}
