<?php

namespace Api\Daniel\Handlers;

use Api\Daniel\Services\FileManager;

class TaskHandler
{
    private FileManager $fileManager;
    private $statusFile;

    public function __construct(FileManager $fileManager, $statusFile)
    {
        $this->fileManager = $fileManager;
        $this->statusFile = $statusFile;
    }

    public function handle($msg): void
    {
        $correlationId = $msg->get('correlation_id');

        sleep(10);

        $statuses = $this->fileManager->readJsonFile($this->statusFile);

        $statuses[$correlationId] = 'Обработано';
        $this->fileManager->writeJsonFile($this->statusFile, $statuses);

        echo "Задача {$correlationId} обработана", "\n";
        $msg->ack();
    }
}