<?php

function run(): void
{
    $post = getPost();

    $string = $post['string'] ?? '';
    $responseCode = 200;
    $responseMessage = 'Все хорошо';
    $isEmpty = emptyValidate($string);
    if ($isEmpty) {
        $responseCode = 400;
        $responseMessage = 'Пустая строка. Все плохо';
    }

    $isEqual = bracketsValidate($string);

    if (!$isEqual) {
        $responseCode = 400;
        $responseMessage = 'Не равное количество скобок. Все плохо';
    }

    http_response_code($responseCode);
    echo $responseMessage;
    exit;
}
