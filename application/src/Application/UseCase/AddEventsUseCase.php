<?php

declare(strict_types=1);

namespace Gesparo\HW\Application\UseCase;

use Gesparo\HW\Application\ConditionFactory;
use Gesparo\HW\Application\EventFactory;
use Gesparo\HW\Application\UseCase\Request\AddEventsRequest;
use Gesparo\HW\Application\UseCase\Request\ConditionDTO;
use Gesparo\HW\Domain\List\EventList;
use Gesparo\HW\Domain\Repository\AddEventsInterface;

class AddEventsUseCase
{
    private AddEventsInterface $storage;
    private EventFactory $eventFactory;
    private ConditionFactory $conditionFactory;

    public function __construct(AddEventsInterface $storage, EventFactory $eventFactory, ConditionFactory $conditionFactory)
    {
        $this->storage = $storage;
        $this->eventFactory = $eventFactory;
        $this->conditionFactory = $conditionFactory;
    }

    public function add(AddEventsRequest $request): void
    {
        $this->storage->add($this->getEventList($request));
    }

    private function getEventList(AddEventsRequest $request): EventList
    {
        $events = [];

        foreach ($request->events as $event) {
            $events[] = $this->eventFactory->create(
                $event->name,
                $event->priority,
                array_map(
                    fn(ConditionDTO $condition) => $this->conditionFactory->create($condition->name, $condition->value),
                    $event->conditions
                )
            );
        }

        return new EventList($events);
    }
}
