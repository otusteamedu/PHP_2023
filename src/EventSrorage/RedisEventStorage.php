<?php
declare(strict_types=1);

namespace RedisApp\EventStorage;

use Predis\Client;
use RedisApp\Event\Event;


class RedisEventStorage implements EventStorageInterface

{

    public function __construct(private Client $redis)
    {
    }

    public function addEvent(Event $event)
    {
        $this->redis->zadd('events', [$this->serializeEvent($event) => $event->priority]);
    }

    public function clearEvents()
    {
        $this->redis->del('events');
    }

    public function findMatchingEvent($userParams)
    {
        $events = $this->redis->zrevrangebyscore('events', '+inf', '-inf');

        foreach ($events as $event) {
            $decodedEvent = $this->deserializeEvent($event);

            if ($this->checkConditions($decodedEvent->conditions, $userParams)) {
                return $decodedEvent;
            }
        }

        return null;
    }

    private function checkConditions($eventConditions, $userParams)
    {
        foreach ($eventConditions as $param => $value) {
            if (!isset($userParams[$param]) || $userParams[$param] != $value) {
                return false;
            }
        }

        return true;
    }

    private function serializeEvent(Event $event)
    {
        return json_encode([$event->priority, $event->conditions, $event->event]);
    }

    private function deserializeEvent($event)
    {
        list($priority, $conditions, $eventData) = json_decode($event, true);

        return new Event($priority, $conditions, $eventData);
    }
}