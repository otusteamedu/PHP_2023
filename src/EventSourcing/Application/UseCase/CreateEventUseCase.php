<?php

declare(strict_types=1);

namespace Otus\App\EventSourcing\Application\UseCase;

use Otus\App\EventSourcing\Application\Contract\EventGatewayInterface;
use Otus\App\EventSourcing\Application\Dto\ConditionDto;
use Otus\App\EventSourcing\Application\Dto\EventDto;
use Otus\App\EventSourcing\Domain\Model\Condition;
use Otus\App\EventSourcing\Domain\Model\Event;

final readonly class CreateEventUseCase
{
    public function __construct(
        private EventGatewayInterface $eventProvider,
    ) {
    }

    public function create(EventDto $eventDto): void
    {
        $event = new Event($eventDto->getId(), $eventDto->getName());

        $conditions = array_map(
            static fn (ConditionDto $conditionDto) => new Condition($conditionDto->getKey(), $conditionDto->getValue()),
            $eventDto->getConditions()
        );

        $this->eventProvider->add(
            event: $event,
            priority: $eventDto->getPriority(),
            conditions: $conditions,
        );
    }
}
