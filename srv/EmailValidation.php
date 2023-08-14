<?php

declare(strict_types=1);

class EmailValidation
{
    public function validateEmail(string $email): string
    {
        if (!preg_match("(^[-\w.]+@([-a-z0-9]+\.)+[a-z]{2,4}$)i", $email)) {
            return 'Некорректный email';
        }

        if (!checkdnsrr(explode('@', $email)[1])) {
            return 'Некорректный домен';
        }

        return 'Валидация прошла успешно';
    }
}