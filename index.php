<?php

declare(strict_types=1);

require_once __DIR__ . '/EmailValidator.php';

$emailVerifier = new EmailValidator();

$emailDataProvider = [
    'alex@gmail.com',
    'alex@mail.ru',
    'alex@yandex.ru',
    'alex@invalid-domain.ru'
];

array_walk(
    $emailDataProvider,
    fn (string $email) => assert($emailVerifier->validate($email))
);
