<?php

use app\Actions\EmailValidation;
use app\Response;

require '../vendor/autoload.php';

$emails = [
    'test@mail.ru',
    'test1@mail.ru',
    'test2@mail.ru',
    'test3@mail.ru'
];

$emailValidation = new EmailValidation();

$validEmails = $emailValidation($emails)['validEmails'];
$invalidEmails = $emailValidation($emails)['invalidEmails'];

$response = <<<RESPONSE
    <h1>ValidEmails: $validEmails</h1>
    <h1>InvalidEmails: $invalidEmails</h1>
RESPONSE;

return $response;
