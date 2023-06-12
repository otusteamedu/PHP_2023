<?php

if($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    echo 'Неопределенный метод запроса';
    return;
}

$bodyJson = file_get_contents('php://input');
$body = json_decode($bodyJson);

if(!isset($body->string)){
    http_response_code(422);
    echo 'Не указан параметр string в теле запроса';
    return;
}

$regExp = '/^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$/m';
preg_match($regExp, $body->string, $matches);

if(count($matches) === 0) {
    http_response_code(400);
    echo 'Строка в поле string некорректна';
    return;
}

http_response_code(200);
echo 'Успешно';
return;

