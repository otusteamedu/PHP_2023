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

Response::stringResponse($emailValidation($emails));
