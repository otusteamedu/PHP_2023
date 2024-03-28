<?php

require __DIR__ . '/../vendor/autoload.php';

use Api\Daniel\Services\RabbitMQClient;
use Api\Daniel\Services\FileManager;
use Api\Daniel\Handlers\RequestHandler;

$rabbitMQClient = new RabbitMQClient('rabbitmq', 5672, 'user', 'password');
$rabbitMQClient->declareQueue('task_queue');

$fileManager = new FileManager();
$requestHandler = new RequestHandler($rabbitMQClient, $fileManager, __DIR__ . '/../data');

$requestHandler->handleRequest();
