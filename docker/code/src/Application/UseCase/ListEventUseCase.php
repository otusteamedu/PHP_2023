<?php

namespace IilyukDmitryi\App\Application\UseCase;

use IilyukDmitryi\App\Application\Dto\ListEventResponse;
use IilyukDmitryi\App\Domain\Repository\EventRepositoryInterface;

class ListEventUseCase
{
    private EventRepositoryInterface $repository;
    
    public function __construct(EventRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function exec(): ListEventResponse
    {
        return new ListEventResponse($this->repository->list());
    }
}