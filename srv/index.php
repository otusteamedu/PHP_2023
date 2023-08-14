<?php

namespace App;

require_once 'Validator.php';

$validator = new Validator();
$string = '(((((())))))';

$result = $validator->validateString($string);

if ($result) {
    http_response_code(200);
    echo 'Запрос выполнен успешно';
} else {
    http_response_code(400);
    echo 'Запрос невыполнен. Ошибка валидации';
}
