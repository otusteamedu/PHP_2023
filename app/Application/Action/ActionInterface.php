<?php

namespace App\Application\Action;

use App\Application\Response\ResponseInterface;
use App\Infrastructure\MessageQueueRepositoryInterface;
use App\Infrastructure\MessageStatusRepositoryInterface;

interface ActionInterface
{
    public function do(
        MessageQueueRepositoryInterface $repositoryQueue,
        MessageStatusRepositoryInterface $repositoryStatus
    ): ResponseInterface;
}
