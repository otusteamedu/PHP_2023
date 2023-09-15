<?php
declare(strict_types = 1);
header('Content-Type: application/json; charset=utf-8');
include 'CheckRequest.php';
include 'JsonResponse.php';

$checkRequest = new CheckRequest();
$response = new JsonResponse();

if(isset($_POST['string']) && mb_strlen($_POST['string']) > 0) {
    if($checkRequest->checkString($_POST['string'])) {
        try {
            echo $response->response(200, 'Строка валидна!');
        } catch (JsonException $e) {
            echo $e->getMessage();
        }
    }
    else {
        try {
            header(sprintf('HTTP/1.1 %s', 400), true, 400);
            echo $response->response(400, 'Строка Невалидна!');
        } catch (JsonException $e) {
            return $e->getMessage();
        }
    }
}
else {
    throw new \RuntimeException('Не передан обязательный параметр string');
}


