<?php

declare(strict_types=1);

require __DIR__ . '../../\vendor\autoload.php';

use Dpankratov\Hw4\Requests\EmailValidation;

$arEmail = [
    'test@test.ru',
    'test@testru',
    'testtest.ru',
    'testtestru',
    'pankratov2010@rambler.ru'
];
$objVerificationData = new EmailValidation();
$arResult = $objVerificationData->email($arEmail);

echo '<pre>';
var_dump($arResult);
