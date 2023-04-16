<?php

$string = $_POST['string'] ?? '';
emptyValidate($string);
bracketsValidate($string);

http_response_code(200);

echo 'Все хорошо';
function bracketsValidate(string $string): void
{
    $open = 0;
    $closed = 0;
    $splits = str_split($string);
    foreach ($splits as $bracket) {
        if ($bracket === '(') {
            $open++;
        } elseif ($bracket === ')') {
            $closed++;
        }
    }

    if ($open !== $closed) {
        http_response_code(400);
        echo 'Не равное количество скобок. Все плохо';
        exit;
    }
}

function emptyValidate(string $string): void
{
    if (empty($string)) {
        http_response_code(400);
        echo 'Пустая строка. Все плохо';
        exit;
    }
}
