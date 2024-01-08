<?php

namespace App\Application\Action\ClearQueue;

use App\Application\Action\ActionInterface;
use App\Application\DTO\ArgumentsDTO;
use App\Application\Response\ResponseInterface;
use App\Application\Response\TheResponse;
use App\Infrastructure\MessageQueueRepositoryInterface;
use App\Infrastructure\MessageStatusRepositoryInterface;

class ClearQueueAction implements ActionInterface
{
    public function __construct(ArgumentsDTO $arguments)
    {
    }

    public function do(
        MessageQueueRepositoryInterface $repositoryQueue,
        MessageStatusRepositoryInterface $repositoryStatus
    ): ResponseInterface {
        $repositoryQueue->clear();

        return TheResponse::make('');
    }
}
