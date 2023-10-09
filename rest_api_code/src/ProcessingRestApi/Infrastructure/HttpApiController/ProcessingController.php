<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\HttpApiController;

use VKorabelnikov\Hw16\MusicStreaming\Application\DataTransfer\Response;

class ProcessingController
{
    protected \PDO $pdo;
    protected RabbitMqHelper $rabbitHelper;

    public function __construct(\PDO $pdo, RabbitMqHelper $rabbitHelper)
    {
        $this->pdo = $pdo;
        $this->rabbitHelper = $rabbitHelper;
    }

    public function add(array $requestParams): Response
    {
        $addProcessingUseCase = new AddProcessingUseCase(new ProcessingMapper($this->pdo), $this->rabbitHelper);
        $addProcessingUseCase->add($requestParams);
        return new Response(true);
    }

    public function update(array $requestParams): Response
    {
        return new Response(true);
    }

    public function getStatus(array $requestParams): Response
    {
        $addProcessingUseCase = new getProcessingStatusUseCase(new ProcessingMapper($this->pdo));
        $addProcessingUseCase->getStatus($requestParams);
        return new Response(true);
    }

    public function getResult(array $requestParams): Response
    {
        $addProcessingUseCase = new getProcessingResultUseCase(new ProcessingMapper($this->pdo));
        $addProcessingUseCase->getResult($requestParams);
        return new Response(true);
    }
}
