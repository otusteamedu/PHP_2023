<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\UseCase\Event;

use Imitronov\Hw12\Application\Repository\EventRepository;

final class ClearEvents
{
    public function __construct(
        private readonly EventRepository $eventRepository,
    ) {
    }

    public function handle(): void
    {
        $this->eventRepository->deleteAll();
    }
}
