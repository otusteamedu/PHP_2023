<?php

namespace Api\Daniel;

use Api\Daniel\Handlers\RequestHandler;
use Api\Daniel\Services\FileManager;
use Api\Daniel\Services\RabbitMQClient;
use Dotenv\Dotenv;

class App
{
    private RequestHandler $requestHandler;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $rabbitMQHost = $_ENV['RABBITMQ_HOST'];
        $rabbitMQPort = $_ENV['RABBITMQ_PORT'];
        $rabbitMQUser = $_ENV['RABBITMQ_USER'];
        $rabbitMQPassword = $_ENV['RABBITMQ_PASSWORD'];
        $rabbitMQClient = new RabbitMQClient($rabbitMQHost, $rabbitMQPort, $rabbitMQUser, $rabbitMQPassword);
        $rabbitMQClient->declareQueue('task_queue');

        $fileManager = new FileManager();
        $this->requestHandler = new RequestHandler($rabbitMQClient, $fileManager, __DIR__ . '/data');
    }

    public function run(): void
    {
        $this->requestHandler->handleRequest();
    }
}