<?php

declare(strict_types=1);

namespace Gesparo\HW\Application\UseCase;

use Gesparo\HW\Application\UseCase\Request\AddEventsRequest;
use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\List\EventList;
use Gesparo\HW\Domain\Repository\AddEventsInterface;
use Gesparo\HW\Domain\ValueObject\Condition;
use Gesparo\HW\Domain\ValueObject\Name;
use Gesparo\HW\Domain\ValueObject\Priority;

class AddEventsUseCase
{
    private AddEventsInterface $storage;

    public function __construct(AddEventsInterface $storage)
    {
        $this->storage = $storage;
    }

    public function add(AddEventsRequest $request): void
    {
        $this->storage->add($this->getEventList($request));
    }

    private function getEventList(AddEventsRequest $request): EventList
    {
        $events = [];

        foreach ($request->events as $event) {
            $conditions = [];

            foreach ($event->conditions as $condition) {
                $conditions[] = new Condition($condition->name, $condition->value);
            }

            $events[] = new Event(new Name($event->name), new Priority($event->priority), $conditions);
        }

        return new EventList($events);
    }
}
