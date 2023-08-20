<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CreateEventDto;
use App\Dto\EventConditionDto;
use App\Dto\FindEventsDto;
use App\Helper\TraceHelper;
use App\Model\Event;
use App\Model\EventCondition;
use App\Model\EventData;
use App\Repository\EventRepositoryInterface;

readonly class EventService
{
    public function __construct(
        private TraceHelper $traceHelper,
        private EventRepositoryInterface $eventRepository,
    ) {
    }

    public function create(CreateEventDto $createEventDto): void
    {
        $span = $this->traceHelper->startSpan(__METHOD__);

        $conditions = [];
        foreach ($createEventDto->conditions as $conditionDto) {
            $conditions[] = new EventCondition($conditionDto->key, $conditionDto->value);
        }
        $event = new Event(
            priority: $createEventDto->priority,
            conditions: $conditions,
            data: new EventData($createEventDto->title, $createEventDto->data),
        );
        $this->eventRepository->create($event);

        $span->end();
    }

    public function clear(): void
    {
        $this->eventRepository->clear();
    }

    public function findMostSuitableByCondition(FindEventsDto $findEventsDto): ?Event
    {
        $conditions = [];
        foreach ($findEventsDto->conditions as $conditionDto) {
            $conditions[] = new EventCondition($conditionDto->key, $conditionDto->value);
        }

        $events = $this->eventRepository->findByConditions($conditions);

        return $this->findSuitableEvent($events, $findEventsDto->conditions);
    }

    /**
     * @param Event[] $events
     * @param EventConditionDto[] $eventConditionsDto
     * @return Event|null
     */
    private function findSuitableEvent(array $events, array $eventConditionsDto): ?Event
    {
        $suitableEvents = [];
        foreach ($events as $event) {
            if ($this->checkEventOnInputConditions($event, $eventConditionsDto)) {
                $suitableEvents[] = $event;
            }
        }

        if (count($suitableEvents) === 0) {
            return null;
        }

        usort($suitableEvents, static function (Event $a, Event $b) {
            return $a->priority <=> $b->priority;
        });

        return $suitableEvents[count($suitableEvents) - 1];
    }

    /**
     * @param Event $event
     * @param EventConditionDto[] $inputConditions
     * @return bool
     */
    private function checkEventOnInputConditions(Event $event, array $inputConditions): bool
    {
        foreach ($event->conditions as $condition) {
            $conditionExists = false;
            foreach ($inputConditions as $inputCondition) {
                if (
                    $condition->key === $inputCondition->key &&
                    $condition->value === $inputCondition->value
                ) {
                    $conditionExists = true;
                    break;
                }
            }
            if (!$conditionExists) {
                return false;
            }
        }

        return true;
    }
}