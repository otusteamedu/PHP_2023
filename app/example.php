<?php

declare(strict_types=1);

use Imitronov\Hw5\EmailValidator;
use Imitronov\Hw5\Exception\ValidationException;

require __DIR__ . '/vendor/autoload.php';

$validator = new EmailValidator();

$emails = [
    '       ',
    'homework+5@otus.ru',
    'home!!!ork-5@mail.ru',
    'hom3work_5@gmail.ru',
    'homew0rk5@ya.ru',
    'home@work5@ya.ru',
    'домашнее_задание@почта.рус',
    'homework5@qwdasdaowerqw.ru',
];

foreach ($emails as $email) {
    try {
        $validator->validate($email);

        echo sprintf('✅ "%s" валидный.', $email) . PHP_EOL;
    } catch (ValidationException $e) {
        echo sprintf('❌ "%s" - %s', $email, $e->getMessage()) . PHP_EOL;
    }
}
