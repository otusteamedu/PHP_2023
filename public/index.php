<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Twent\EmailValidator\EmailValidator;

$emailList = [
    'mail@example.com',
    'help@otus.ru'
];

try {
    EmailValidator::handle(...$emailList);
    echo 'Переданный/ые email корректен/ны' . PHP_EOL;
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
