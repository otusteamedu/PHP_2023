<?php

namespace IilyukDmitryi\App\Application\UseCase;

use IilyukDmitryi\App\Domain\Repository\EventRepositoryInterface;

class DeleteEventUseCase
{
    private EventRepositoryInterface $repository;
    
    public function __construct(EventRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function exec(): int
    {
        return $this->repository->deleteAll();
    }
}