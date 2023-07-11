<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Factory;

use Imitronov\Hw12\Application\Dto\EventDto;
use Imitronov\Hw12\Application\Repository\EventRepository;
use Imitronov\Hw12\Domain\Entity\Event;

final class EventFactory
{
    public function __construct(
        private readonly ConditionFactory $conditionFactory,
        private readonly EventDataFactory $eventDataFactory,
        private readonly EventRepository $eventRepository,
    ) {
    }

    public function makeFromDto(EventDto $dto): Event
    {
        return new Event(
            $this->eventRepository->nextId(),
            $dto->priority,
            array_map(
                fn ($conditionDto) => $this->conditionFactory->makeFromDto($conditionDto),
                $dto->conditions,
            ),
            $this->eventDataFactory->makeFromDto($dto->data),
        );
    }
}
