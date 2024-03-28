<?php

require __DIR__ . '/../vendor/autoload.php';

use Api\Daniel\Services\FileManager;
use Api\Daniel\Handlers\TaskHandler;
use Api\Daniel\Services\RabbitMQClient;


$fileManager = new FileManager();
$taskHandler = new TaskHandler($fileManager, __DIR__ . '/../data/statuses.json');

$rabbitMQClient = new RabbitMQClient('rabbitmq', 5672, 'user', 'password');
$rabbitMQClient->declareQueue('task_queue');

$callback = function($msg) use ($taskHandler) {
    $taskHandler->handle($msg);
};

$rabbitMQClient->setCallback($callback);
$rabbitMQClient->startConsuming('task_queue');
