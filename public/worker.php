<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

// Путь к файлу статусов
$statusFile = __DIR__ . '/../data/statuses.json';

// Создаем директорию для статусов задач, если она не существует
$dataDir = __DIR__ . '/../data';
if (!file_exists($dataDir)) {
    mkdir($dataDir, 0777, true);
}

$callback = function($msg) use ($statusFile) {
    $taskData = json_decode($msg->body, true);
    $correlationId = $msg->get('correlation_id');

    // Здесь обрабатываем задачу...
    sleep(10); // Имитация обработки задачи

    // Читаем текущие статусы задач
    $statuses = file_exists($statusFile) ? json_decode(file_get_contents($statusFile), true) : [];

    // Обновляем статус задачи в файле
    $statuses[$correlationId] = 'Обработано';
    file_put_contents($statusFile, json_encode($statuses));

    echo "Задача {$correlationId} обработана", "\n";
    $msg->ack();
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
