<?php

require __DIR__ . '/../vendor/autoload.php';

// Конфигурация RabbitMQ
$rabbitMQClient = new \Api\Daniel\Services\RabbitMQClient('rabbitmq', 5672, 'user', 'password');
$rabbitMQClient->declareQueue('task_queue');

$fileManager = new \Api\Daniel\Services\FileManager();
$requestHandler = new \Api\Daniel\RequestHandler($rabbitMQClient, $fileManager, __DIR__ . '/../data');

$requestHandler->handleRequest();
