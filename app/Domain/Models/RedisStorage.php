<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Application\Contracts\StorageInterface;
use JsonException;
use Predis\Client;

class RedisStorage implements StorageInterface
{
    private Client $redis;

    public function __construct(array $options)
    {
        $this->redis = new Client($options);
    }

    /**
     * @throws JsonException
     */
    public function find(array $params): mixed
    {
        $event = [];
        if (!($events = $this->redis->sscan(Event::KEY, 0, ['COUNT' => 1000])[1] ?? [])) {
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

    public function add(Event $event): bool
    {
        $this->redis->sadd($event::KEY, (array) $event->getId());
        $this->redis->hset($event->getId(), $event::NAME, $event->getName());
        $this->redis->hset($event->getId(), $event::PRIORITY, (string) $event->getPriority());
        $this->redis->hset($event->getId(), $event::CONDITIONS, $event->getConditions());

        return true;
    }

    public function clear(): void
    {
        $this->redis->flushDB();
    }
}
