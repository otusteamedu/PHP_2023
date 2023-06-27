<?php

// require 'Validator.php';

// $validator = new Validator;
// $string = '(()()()()))((((()()()))(()()()(((()))))))';

// $result = $validator->validateString($_POST['string'] = $string);

// if ($result) {
//     http_response_code(200);
//     echo 'Запрос выполнен успешно';
// } else {
//     http_response_code(400);
//     echo 'Запрос невыполнен. Ошибка валидации';
// }


echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
