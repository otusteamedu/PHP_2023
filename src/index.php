<?php

require __DIR__ . '/../vendor/autoload.php';

use Api\Daniel\Services\RabbitMQClient;
use Api\Daniel\Services\FileManager;
use Api\Daniel\Handlers\RequestHandler;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$rabbitMQHost = $_ENV['RABBITMQ_HOST'];
$rabbitMQPort = $_ENV['RABBITMQ_PORT'];
$rabbitMQUser = $_ENV['RABBITMQ_USER'];
$rabbitMQPassword = $_ENV['RABBITMQ_PASSWORD'];

$rabbitMQClient = new RabbitMQClient($rabbitMQHost, $rabbitMQPort, $rabbitMQUser, $rabbitMQPassword);
$rabbitMQClient->declareQueue('task_queue');

$fileManager = new FileManager();
$requestHandler = new RequestHandler($rabbitMQClient, $fileManager, __DIR__ . '/../data');

$requestHandler->handleRequest();
