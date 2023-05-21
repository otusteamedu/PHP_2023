<?php

namespace Sva\Event\App;

use Sva\Event\Domain\EventRepositoryInterface;

class Service
{
    public function __construct(private readonly EventRepositoryInterface $eventsRepository)
    {
    }

    public function getList(): array
    {
        return $this->eventsRepository->getList();
    }
}
