<?php
declare(strict_types=1);

require_once __DIR__ . '/Services/EmailValidator.php';

$emailList = [
    'info@otus.ru',
    'invalid-email-ru',
    'user@google.com',
    'admin@gooooooooooooooooooooooooogle.com',
];

$emailValidator = new Services\EmailValidator();

foreach ($emailList as $email) {
    if ($emailValidator->validate($email)) {
        echo "$email - Валидный email\n";
    } else {
        echo "$email - Невалидный email\n";
    }
}
