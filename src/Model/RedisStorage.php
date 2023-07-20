<?php

namespace App\Model;

use Predis\Client;

class RedisStorage implements StorageInterface
{
    private $redis;

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    public function addEvent(Event $event)
    {
        $this->redis->rpush('events', serialize($event));
    }

    public function clearEvents()
    {
        $this->redis->del('events');
    }

    public function findMatchingEvent(array $params)
    {
        $events = $this->redis->lrange('events', 0, -1);

        $matchingEvent = null;
        $highestPriority = PHP_INT_MIN;

        foreach ($events as $eventSerialized) {
            $event = unserialize($eventSerialized);

            if ($event instanceof Event && $event->matchesParams($params) && $event->getPriority() > $highestPriority) {
                $matchingEvent = $event;
                $highestPriority = $event->getPriority();
            }
        }

        return $matchingEvent;
    }
}
