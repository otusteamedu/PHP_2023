<?php

declare(strict_types=1);

use App\Helpers\Email;

require 'vendor/autoload.php';

$emailRecords = [
    'test@ya.ru',
    'teststatic@ya.ru',
    'werewr.ertr',
    '12221@123.qwe'
];

try {
    dump(Email::validateEmails($emailRecords));
} catch (RuntimeException $e) {
    dump($e);
}