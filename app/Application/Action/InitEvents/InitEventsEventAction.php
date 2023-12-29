<?php

namespace App\Application\Action\InitEvents;

use App\Application\Action\EventActionInterface;
use App\Application\Response\NullResponse;
use App\Application\Response\ResponseInterface;
use App\Infrastructure\RepositoryInterface;

class InitEventsEventAction implements EventActionInterface
{
    public function __construct(array $arguments)
    {
    }

    public function do(RepositoryInterface $repository): ResponseInterface
    {
        $repository->init();

        return NullResponse::make();
    }
}

