<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

$memcached = new Memcached();
$memcached->addServer('localhost', 11211);

$callback = function($msg) use ($memcached) {
    $taskData = json_decode($msg->body, true);
    $correlationId = $msg->get('correlation_id');

    // Здесь обрабатываем задачу...
    sleep(100); // Имитация обработки задачи

    // Обновляем статус задачи в Memcached
    $memcached->set($correlationId, 'Обработано');

    echo 'Задача обработана', "\n";
    $msg->ack();
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();

