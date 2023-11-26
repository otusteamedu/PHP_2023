<?php

declare(strict_types=1);

$string = $_POST['string'] ?? '';
$string = preg_replace('/[^\(\)]/', '', $string);

if (!$string) {
    errorResponse('В строке нет ни одной скобки');

    return;
}

$bracketCosts = [
    '(' => 1,
    ')' => -1,
];

$bracketsArray       = mb_str_split($string);
$bracketsCostsResult = 0;

foreach ($bracketsArray as $bracket) {
    $bracketsCostsResult += $bracketCosts[$bracket];

    if ($bracketsCostsResult < 0) {
        break;
    }
}

if ($bracketsCostsResult !== 0) {
    errorResponse('Строка со скобками не валидна');
} else {
    successResponse('Строка со скобками валидна');
}

/**
 * @param $message
 *
 * @return void
 */
function successResponse($message): void
{
    http_response_code(200);
    echo $message;
}

/**
 * @param $message
 *
 * @return void
 */
function errorResponse($message): void
{
    http_response_code(400);
    echo $message;
}
