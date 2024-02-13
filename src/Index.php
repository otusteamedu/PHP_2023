<?php

use Dev\Php2023\EmailValidator;

$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}

$emails = ['123@123.ru', 'email', 'test.test', 'ivan@ivanov.mail'];
$validator = new EmailValidator();
$result = $validator->validateEmail($emails);

print_r($result);