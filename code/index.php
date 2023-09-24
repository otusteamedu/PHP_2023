<?php

declare(strict_types=1);

use Eevstifeev\Emailvalidator\Controllers\EmailValidateController;

require __DIR__ . '/vendor/autoload.php';

$emailList = [
    'info@otus.ru',
    'invalid-email-ru',
    'user@google.com',
    'admin@gooooooooooooooooooooooooogle.com',
];

print_r(EmailValidateController::getValidate($emailList));
