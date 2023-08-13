<?php

declare(strict_types=1);

namespace Ro\Php2023\Storage;

use Predis\ClientInterface;
use Ro\Php2023\Entities\EventInterface;

class EventStorage implements EventStorageInterface
{
    public function __construct(private readonly ClientInterface $redisClient)
    {
        $this->redisClient->connect();
    }

    public function addEvent(EventInterface $event)
    {
        $eventId = $this->redisClient->incr("event");
        $eventKey = "event:$eventId";

        return $this->redisClient->hmset($eventKey, [
            'priority' => $event->getPriority(),
            'event' => json_encode($event->getEvent()),
            'conditions' => json_encode($event->getConditions()->toArray())
        ]);
    }

    public function getAll(): array
    {
        $eventKeys = $this->redisClient->keys('event:*');
        $events = [];

        foreach ($eventKeys as $eventKey) {
            $eventData = $this->redisClient->hgetall($eventKey);
            if (!empty($eventData)) {
                $events[] = $eventData;
            }
        }

        return $events;
    }

    public function getById(string $id): array
    {
        return $this->redisClient->hgetall($id);
    }

    public function clearEvents()
    {
        return $this->redisClient->flushdb();
    }

    public function getMatchingEvent($requestedConditions)
    {
        $events = $this->getAll();

        $matchingEvents = [];
        foreach ($events as $event) {
            $conditions = json_decode($event['conditions'], true);
            $match = true;

            foreach ($requestedConditions as $param => $value) {
                $match = isset($conditions[$param]) && $conditions[$param] === $value;

                if (!$match) {
                    break;
                }
            }

            if ($match) {
                $matchingEvents[] = [
                    'priority' => $event['priority'],
                    'event' => json_decode($event['event'], true)
                ];
            }
        }

        if (empty($matchingEvents)) {
            return null;
        }

        usort($matchingEvents, fn($a, $b) => $b['priority'] - $a['priority']);

        return $matchingEvents[0]['event'];
    }
}
