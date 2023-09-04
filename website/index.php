<?php

declare(strict_types=1);

use App\Helpers\EmailValidator;

require 'vendor/autoload.php';

$emailRecords = [
    'test@ya.ru',
    'teststatic@ya.ru',
    'werewr.ertr',
    '12221@123.qwe'
];

try {
    $validator = new EmailValidator();
    $validator->validate($emailRecords)->printResult();
} catch (RuntimeException $e) {
    dump($e);
}
