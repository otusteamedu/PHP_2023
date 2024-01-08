<?php

namespace App\Application\Action\ReadQueueMessages;

use App\Application\Action\ActionInterface;
use App\Application\DTO\ArgumentsDTO;
use App\Application\Response\ResponseInterface;
use App\Application\Response\TheResponse;
use App\Infrastructure\MessageQueueRepositoryInterface;
use App\Infrastructure\MessageStatusRepositoryInterface;

class ReadQueueMessagesAction implements ActionInterface
{
    public function __construct(ArgumentsDTO $arguments)
    {
        //
    }

    public function do(
        MessageQueueRepositoryInterface $repositoryQueue,
        MessageStatusRepositoryInterface $repositoryStatus
    ): ResponseInterface {
        $repositoryQueue->read();

        return TheResponse::make('');
    }
}
