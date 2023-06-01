<?php

$arEmail = [
    'test@test.ru',
    'test@testru',
    'testtest.ru',
    'testtestru',
    'igonin-1993@yandex.ru'
];
$response = verificationEmail($arEmail);
var_dump($response);

function verificationEmail(array $arEmail)
{
    $strResult = '';
    $re = '/.*@(.*\..*)/m';

    foreach($arEmail as $email){
        preg_match_all($re, $email, $matches, PREG_SET_ORDER);
        $strResult .= '<pre>';
        if(!empty($matches)){
            $strResult .= "{$matches[0][0]} - валидный e-mail" . PHP_EOL;
            getmxrr($matches[0][1], $hosts);
            $mxHost = $hosts[0] ?? "не найдена";
            $strResult .= "MX запись для домена {$matches[0][1]}: " . $mxHost;
        }else{
            $strResult .= "{$email} не валидно";
        }
    }
    return $strResult;
}
