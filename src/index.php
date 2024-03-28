<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Настройки соединения с RabbitMQ
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);

// Путь к директории и файлу, где будут храниться статусы задач
$dataDir = __DIR__ . '/../data';
$statusFile = $dataDir . '/statuses.json';

// Создаем директорию для статусов задач, если она не существует
if (!file_exists($dataDir)) {
    mkdir($dataDir, 0777, true);
}

// Чтение текущих статусов задач из файла
$statuses = file_exists($statusFile) ? json_decode(file_get_contents($statusFile), true) : [];

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'] ?? 'Undefined task'; // Проверка на существование переменной $_POST['task']
    $data = json_encode(['task' => $task]);
    $correlationId = uniqid();

    // Записываем статус 'В обработке' в файл
    $statuses[$correlationId] = 'В обработке';
    file_put_contents($statusFile, json_encode($statuses));

    $msg = new AMQPMessage($data, [
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        'correlation_id' => $correlationId
    ]);
    $channel->basic_publish($msg, '', 'task_queue');

    echo json_encode(['status' => 'success', 'correlationId' => $correlationId]);
}

// Обработка GET-запроса
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['correlationId'])) {
    $correlationId = $_GET['correlationId'];

    // Чтение статуса задачи из файла
    $status = $statuses[$correlationId] ?? false;

    if ($status === false) {
        echo json_encode(['error' => 'Задача не найдена']);
    } else {
        echo json_encode(['status' => $status]);
    }
}

$channel->close();
$connection->close();
