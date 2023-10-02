<?php
// index.php

require 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Подключение к RabbitMQ
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

// Определение очереди
$queueName = 'banking_queue';
$channel->queue_declare($queueName, false, false, false, false);

// Обработка POST-запроса от пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получите данные из формы
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Генерируйте банковскую выписку и сохраните результат в переменной $statement

    // Отправьте результат в очередь
    $message = new AMQPMessage($statement);
    $channel->basic_publish($message, '', $queueName);

    echo "Запрос на банковскую выписку отправлен в обработку.";
}

// Закрытие соединения
$channel->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запрос на банковскую выписку</title>
</head>
<body>
    <h1>Запрос на банковскую выписку</h1>
    <form method="POST" action="index.php">
        <label for="start_date">Дата начала:</label>
        <input type="date" id="start_date" name="start_date" required>
        <br>
        <label for="end_date">Дата окончания:</label>
        <input type="date" id="end_date" name="end_date" required>
        <br>
        <input type="submit" value="Отправить запрос">
    </form>
</body>
</html>
