<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\Repository\RepositoryInterface;
use src\Application\UseCase\Request\AddNewEventRequest;
use src\Domain\Event;

class AddNewEventUseCase
{
    public function __construct(
        private RepositoryInterface $repository
    )
    {
    }

    public function __invoke(AddNewEventRequest $request): void
    {
        $this->repository->addNewEvent(
            new Event(
                priority: $request->getPriority(),
                event: $request->getEvent(),
                conditions: [
                    $request->getParam1(),
                    $request->getParam2()
                ]
            )
        );
    }
}
