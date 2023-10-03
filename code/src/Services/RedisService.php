<?php

declare(strict_types=1);

namespace Eevstifeev\Hw12\Services;

use Eevstifeev\Hw12\Interfaces\StorageServiceInterface;
use Eevstifeev\Hw12\Models\Event;
use Predis\Client;

class RedisService implements StorageServiceInterface
{
    private Client $redis;

    public function __construct()
    {
        $this->redis = new Client([
            'host' => getenv('REDIS_HOST'),
            'port' => getenv('REDIS_PORT'),
        ]);
    }

    public function addEvent(array $data): Event
    {
        $event = new Event();
        $event->setPriority($data['priority']);
        $event->setConditions($data['conditions']);
        $event->setEvent($data['event']);
        $this->redis->hmset($this->getEventKey($event->getUuid()), $event->toArray());

        return $event;
    }

    public function clearEvent(mixed $eventUuid): bool
    {
        $eventKey = $this->getEventKey($eventUuid);
        $this->redis->del([$eventKey]);
        return true;
    }

    public function clearAllEvents(): bool
    {
        $eventKeys = $this->redis->keys('event:*');
        foreach ($eventKeys as $eventKey) {
            $this->redis->del([$eventKey]);
        }
        return true;
    }

    public function getEventByParams(array $params): ?Event
    {
        $eventKeys = $this->redis->keys('event:*');
        $bestEvent = null;
        foreach ($eventKeys as $eventKey) {
            $eventData = $this->redis->hgetall($eventKey);
            $event = new Event();
            $event->fromArray($eventData);
            if ($this->checkConditions($params, $event->getConditions())) {
                if ($bestEvent === null || $event->getPriority() > $bestEvent->getPriority()) {
                    $bestEvent = $event;
                }
            }
        }
        return $bestEvent;
    }

    public function getEventByUuid(string $uuid): ?Event
    {
        $eventKey = $this->getEventKey($uuid);
        $eventData = $this->redis->hgetall($eventKey);
        $event = new Event();
        $event->fromArray($eventData);
        return $event;
    }

    private function checkConditions(array $params, array $conditions): bool
    {
        foreach ($params as $key => $value) {
            if (!isset($conditions[$key]) || $conditions[$key] != $value) {
                return false;
            }
        }
        return true;
    }

    private function getEventKey($uuid): string
    {
        return 'event:' . $uuid;
    }
}
