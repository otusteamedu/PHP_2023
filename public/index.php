<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Rabbit\Daniel\App;


$app = new App();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestData = [
        'startDate' => $_POST['startDate'] ?? null,
        'endDate' => $_POST['endDate'] ?? null,
        'notificationMethod' => $_POST['notificationMethod'] ?? null,
        'chat_id' => CHAT_ID,
        'email' => EMAIL
    ];

    try {
        $response = $app->handleRequest($requestData);
        echo $response;
    } catch (Exception $e) {
        http_response_code(500);
        echo "Произошла ошибка при обработке запроса: " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "Метод запроса не поддерживается";
}