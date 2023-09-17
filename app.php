<?php

declare(strict_types=1);

use App\Validators\Email as EmailValidator;

require __DIR__ . '/vendor/autoload.php';

$emails = [
    'abc',
    'test@domain.com',
    'test@gmail.com',
    'test@mail.ru',
    'test@yandex.ru',
];

$emailValidator = new EmailValidator();
foreach ($emails as $email) {
    try {
        $emailValidator->validate($email);
        echo "$email: Is valid";
    } catch(Exception $e) {
        echo "$email: {$e->getMessage()}";
    }
    echo PHP_EOL;
}
