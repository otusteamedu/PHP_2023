<?php

namespace App\Application\Action\ClearAllEvents;

use App\Application\Action\EventActionInterface;
use App\Application\Response\NullResponse;
use App\Application\Response\ResponseInterface;
use App\Infrastructure\RepositoryInterface;

class ClearAllEventsEventAction implements EventActionInterface
{
    public function __construct(array $arguments)
    {
    }

    public function do(RepositoryInterface $repository): ResponseInterface
    {
        $repository->clearAllEvents();

        return NullResponse::make();
    }
}
