<?php

namespace App\Application\Action\ReadQueueStatusMessage;

use App\Application\Action\ActionInterface;
use App\Application\DTO\ArgumentsDTO;
use App\Application\Response\ResponseInterface;
use App\Application\Response\TheResponse;
use App\Infrastructure\MessageQueueRepositoryInterface;
use App\Infrastructure\MessageStatusRepositoryInterface;

class ReadQueueStatusMessageAction implements ActionInterface
{
    private string $uuidKey;

    public function __construct(ArgumentsDTO $arguments)
    {
        $this->uuidKey = $arguments->getUuid();
    }

    public function do(
        MessageQueueRepositoryInterface $repositoryQueue,
        MessageStatusRepositoryInterface $repositoryStatus
    ): ResponseInterface {
        return TheResponse::createFromArray([
            'status' => $repositoryStatus->get($this->uuidKey),
            'uuid' => $this->uuidKey
        ]);
    }
}
