<?php

function sendResponse($status, $message): void
{
    http_response_code($status);
    echo $message;
}
function handleRequest(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('HTTP/1.1 405 Method Not Allowed');
        header('Allow: POST');
        return;
    }

    $string = $_POST['string'];
    if (empty($string)) {
        sendResponse(400, 'Bad Request: string parameter is missing or empty');
        return;
    }
    // считаем количество открытых и закрытых скобок и проверяем наличие
    $open = [];
    for ($i = 0; $i < strlen($string); $i++) {
        if ($string[$i] === '(') {
            $open[] = $i;
        }
        if ($string[$i] === ')') {
            if (empty($open)) {
                sendResponse(400, 'Bad Request: closing bracket doesn\'t match opening bracket');
                return;
            }
            array_pop($open);
        }
    }
    if (!empty($open)) {
        sendResponse(400, 'Bad Request: opening bracket doesn\'t match closing bracket');
        return;
    }
    // если все проверки пройдены успешно, выводим ответ 200 OK
    sendResponse(200, 'Everything is OK');
}

handleRequest();
