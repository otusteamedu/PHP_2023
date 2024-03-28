<?php

namespace Api\Daniel;

use Api\Daniel\Services\FileManager;
use Api\Daniel\Services\RabbitMQClient;

class RequestHandler
{
    private $rabbitMQClient;
    private $fileManager;
    private $dataDir;
    private $statusFile;

    public function __construct(RabbitMQClient $rabbitMQClient, FileManager $fileManager, $dataDir)
    {
        $this->rabbitMQClient = $rabbitMQClient;
        $this->fileManager = $fileManager;
        $this->dataDir = $dataDir;
        $this->statusFile = $this->dataDir . '/statuses.json';
    }

    public function handleRequest(): void
    {
        $this->fileManager->ensureDirectoryExists($this->dataDir);
        $statuses = $this->fileManager->readJsonFile($this->statusFile);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePost($statuses);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['correlationId'])) {
            $this->handleGet($statuses);
        }

        $this->rabbitMQClient->close();
    }

    private function handlePost(&$statuses): void
    {
        $task = $_POST['task'] ?? 'Undefined task';
        $data = json_encode(['task' => $task]);
        $correlationId = uniqid();

        $statuses[$correlationId] = 'В обработке';
        $this->fileManager->writeJsonFile($this->statusFile, $statuses);

        $this->rabbitMQClient->publish('task_queue', $data, $correlationId);

        echo json_encode(['status' => 'success', 'correlationId' => $correlationId]);
    }

    private function handleGet(&$statuses): void
    {
        $correlationId = $_GET['correlationId'];
        $status = $statuses[$correlationId] ?? false;

        if ($status === false) {
            echo json_encode(['error' => 'Задача не найдена']);
        } else {
            echo json_encode(['status' => $status]);
        }
    }
}