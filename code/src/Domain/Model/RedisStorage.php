<?php

declare(strict_types=1);

namespace Art\Code\Domain\Model;

use JsonException;
use Predis\Client;

class RedisStorage extends Storage
{
    private Client $redis;

    public function __construct(array $options)
    {
        $this->redis = new Client($options);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws JsonException
     */
    public function find(array $params): mixed
    {
        $event = [];
        if (!($events = $this->redis->smembers(Event::KEY))) {
            return $event;
        }

        $relatedEvents = [];
        foreach ($events as $eventID) {
            $conditions = json_decode($this->redis->hget($eventID, Event::CONDITIONS), true, 512, JSON_THROW_ON_ERROR);

            $countSameConditions = 0;
            foreach ($conditions as $parameterKey => $parameterValue) {
                if ($params[$parameterKey] === $parameterValue) {
                    $countSameConditions++;
                }
            }

            if (count($conditions) === $countSameConditions) {
                $relatedEvents[$eventID] = [
                    Event::NAME       => $this->redis->hget($eventID, Event::NAME),
                    Event::PRIORITY   => $this->redis->hget($eventID, Event::PRIORITY),
                    Event::CONDITIONS => $this->redis->hget($eventID, Event::CONDITIONS),
                ];
            }
        }

        if ($relatedEvents) {
            usort($relatedEvents, static fn ($a, $b) => $a[Event::PRIORITY] < $b[Event::PRIORITY]);
            $event = reset($relatedEvents);
        }

        return $event;
    }

    /**
     * @param Event $event
     * @return bool
     */
    public function add(Event $event): bool
    {
        $this->redis->sadd($event::KEY, (array) $event->getId());
        $this->redis->hset($event->getId(), $event::NAME, $event->getName());
        $this->redis->hset($event->getId(), $event::PRIORITY, $event->getPriority());
        $this->redis->hset($event->getId(), $event::CONDITIONS, $event->getConditions());

        return true;
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->redis->flushDB();
    }
}
