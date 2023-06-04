<?php

require_once('./class.php');

$arEmail = [
    'test@test.ru',
    'test@testru',
    'testtest.ru',
    'testtestru',
    'igonin-1993@yandex.ru'
];
$objVerificationData = new VerificationData();
$arResult = $objVerificationData->email($arEmail);

echo '<pre>';
var_dump($arResult);