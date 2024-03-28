<?php

require __DIR__ . '/../vendor/autoload.php';

use Api\Daniel\Services\FileManager;
use Api\Daniel\Handlers\TaskHandler;
use Api\Daniel\Services\RabbitMQClient;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$rabbitMQHost = $_ENV['RABBITMQ_HOST'];
$rabbitMQPort = $_ENV['RABBITMQ_PORT'];
$rabbitMQUser = $_ENV['RABBITMQ_USER'];
$rabbitMQPassword = $_ENV['RABBITMQ_PASSWORD'];

$fileManager = new FileManager();
$taskHandler = new TaskHandler($fileManager, __DIR__ . '/../data/statuses.json');

$rabbitMQClient = new RabbitMQClient($rabbitMQHost, $rabbitMQPort, $rabbitMQUser, $rabbitMQPassword);
$rabbitMQClient->declareQueue('task_queue');

$callback = function($msg) use ($taskHandler) {
    $taskHandler->handle($msg);
};

$rabbitMQClient->setCallback($callback);
$rabbitMQClient->startConsuming('task_queue');
