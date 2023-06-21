<?php

require_once('./class.php');
use Vendor\HomeWork;

$arEmail = [
    'test@test.ru',
    'test@testru',
    'testtest.ru',
    'testtestru',
    'igonin-1993@yandex.ru'
];
$objVerificationEmail = new Vendor\HomeWork\EmailVerifier();
$arResult = $objVerificationEmail->verify($arEmail);

echo '<pre>';
var_dump($arResult);
