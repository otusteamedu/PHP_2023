<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\UseCase\Event;

use Imitronov\Hw12\Application\Factory\EventFactory;
use Imitronov\Hw12\Application\Repository\EventRepository;

final class CreateEvents
{
    public function __construct(
        private readonly EventRepository $eventRepository,
        private readonly EventFactory $eventFactory,
    ) {
    }

    public function handle(CreateEventsInput $input): array
    {
        $result = [];

        foreach ($input->getEvents() as $eventDto) {
            $result[] = $this->eventRepository->create(
                $this->eventFactory->makeFromDto($eventDto),
            );
        }

        return $result;
    }
}
