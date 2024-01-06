<?php

namespace App\Application\Action\ReadQueueMessages;

use App\Application\Action\ActionInterface;
use App\Application\DTO\ArgumentsDTO;
use App\Application\Response\ResponseInterface;
use App\Application\Response\TheResponse;
use App\Infrastructure\QueueRepositoryInterface;

class ReadQueueMessagesAction implements ActionInterface
{
    private string $notifyWay;

    public function __construct(ArgumentsDTO $arguments)
    {
        $this->notifyWay = $arguments->getNotify();
    }

    public function do(QueueRepositoryInterface $repository): ResponseInterface
    {
        $repository->readMessagesAndNotify($this->notifyWay);

        return TheResponse::make('');
    }
}
