<?php
declare(strict_types=1);

function emailVerification(string $email): void
{
    try {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Почта $email не валидна!");
        }

        $emailDomain = explode('@', $email);

        if (!checkdnsrr($emailDomain[1], "MX")) {
            throw new Exception("MX запись для $emailDomain[1] не найдена!");
        }
    } catch (Exception $e) {
        echo 'Произошла ошибка: ' . $e->getMessage() . PHP_EOL;
    }

}

emailVerification('test@ya.ru');
emailVerification('testya.ru');
emailVerification('test@ya.ru11');