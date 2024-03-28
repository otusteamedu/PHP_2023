<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Настройки соединения с RabbitMQ
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');
$channel = $connection->channel();
$channel->queue_declare('task_queue', false, true, false, false);

// Настройки соединения с Memcached
$memcached = new Memcached();
$memcached->addServer('localhost', 11211);

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_encode(['task' => $_POST['task']]);
    $correlationId = uniqid();

    $memcached->set($correlationId, 'В обработке');

    $msg = new AMQPMessage($data,
        array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            'correlation_id' => $correlationId));
    $channel->basic_publish($msg, '', 'task_queue');

    echo json_encode(['status' => 'success', 'correlationId' => $correlationId]);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['correlationId'])) {
    $correlationId = $_GET['correlationId'];
    $status = $memcached->get($correlationId);

    if ($status === false) {
        echo json_encode(['error' => 'Задача не найдена']);
    } else {
        echo json_encode(['status' => $status]);
    }
}

$channel->close();
$connection->close();
