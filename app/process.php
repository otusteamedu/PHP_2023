<?php
require 'vendor/autoload.php'; // Подключение Composer автозагрузчика

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

// Функция для отправки результата в очередь
function sendResultToQueue($data) {
    $connection = new AMQPConnection([
        'host' => 'rabbitmq', // Имя контейнера RabbitMQ из docker-compose.yml
        'port' => 5672,
        'user' => 'guest',
        'password' => 'guest',
    ]);
    $connection->connect();

    $channel = new AMQPChannel($connection);
    $exchange = new AMQPExchange($channel);
    $exchange->setName('notification_exchange');
    $exchange->setType(AMQP_EX_TYPE_DIRECT);
    $exchange->declareExchange();

    $message = new AMQPMessage(json_encode($data));
    $exchange->publish($message, 'notification_routing_key');

    $connection->close();
}

// Обработка запроса
$data = [
    'type' => 'notification_result', // Тип результата
    'content' => 'Результат обработки запроса', // Данные результата
];

// Отправка результата в очередь
sendResultToQueue($data);
