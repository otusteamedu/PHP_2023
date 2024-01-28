<?php

namespace Dimal\Hw12;

use Redis;

class RedisEventStorage extends EventStorage
{

    private $r;
    private $key = 'events';

    public function __construct(Redis $redis)
    {
        $this->r = $redis;
    }

    public function addEvent(Event $event): void
    {
        $this->r->zAdd($this->key, $event->getPriority(), $event->getEventString());
    }

    public function searchEvent(EventConditions $conditions): ?Event
    {
        $events = $this->r->zRevRangeByScore($this->key, '+inf', '-inf', ['withscores' => true]);
        foreach ($events as $event => $score) {
            $event = json_decode($event, true);
            if ($event['conditions'] == $conditions->getConditions()) {
                return new Event($conditions, $event['event'], $score);
            }
        }
        return null;
    }

    public function clearEvents(): void
    {
        $this->r->del($this->key);
    }
}
