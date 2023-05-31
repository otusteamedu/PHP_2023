<?php

declare(strict_types=1);

require_once __DIR__ . '/EmailValidator.php';

$emailValidator = new EmailValidator();

$emails = [
    'alex@gmail.com',
    'alex@mail.ru',
    'alex@yandex.ru',
    'alex@invalid-domain.ru'
];

$emailValidator->validateBatch($emails);
$emailValidator->validate('alex@valid.domain');
