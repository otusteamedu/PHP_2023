<?php

namespace App\Application\Action\ClearQueue;

use App\Application\Action\ActionInterface;
use App\Application\DTO\ArgumentsDTO;
use App\Application\Response\ResponseInterface;
use App\Application\Response\TheResponse;
use App\Infrastructure\QueueRepositoryInterface;

class ClearQueueAction implements ActionInterface
{
    public function __construct(ArgumentsDTO $arguments)
    {
    }

    public function do(QueueRepositoryInterface $repository): ResponseInterface
    {
        $repository->clear();

        return TheResponse::make('');
    }
}
