<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Redis;

use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\List\GetConditionList;
use Gesparo\HW\Domain\ValueObject\Condition;
use Gesparo\HW\Domain\ValueObject\Name;
use Gesparo\HW\Domain\ValueObject\Priority;

class EventGetter
{
    use ConditionNameTrait;

    private \Redis $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws \RedisException
     * @throws RedisStorageException
     */
    public function get(GetConditionList $list): ?Event
    {
        $conditionName = $this->getConditionName($list->getAll());
        $events = $this->redis->zRevRange($conditionName, 0, 1);

        if (empty($events)) {
            return null;
        }

        $event = $events[0];
        $eventData = $this->getEventData($event);

        $result = $this->convertToEvent($eventData);

        $deleteResult = $this->redis->zrem($conditionName, $event);

        if ($deleteResult === false) {
            throw RedisStorageException::cannotDeleteKey($event);
        }

        return $result;
    }

    /**
     * @throws \RedisException
     * @throws RedisStorageException
     */
    private function getEventData(string $eventName): array
    {
        $result = $this->redis->hGetAll($eventName);

        if (empty($result)) {
            throw RedisStorageException::cannotGetEventData($eventName);
        }

        return (array) $result;
    }

    private function convertToEvent(array $eventData): Event
    {
        $priority = new Priority((int) $eventData['priority']);
        $eventName = new Name($eventData['event']);

        unset($eventData['priority'], $eventData['event']);

        $wordLength = strlen('condition:');

        $conditions = [];

        foreach ($eventData as $key => $value) {
            $conditions[] = new Condition(substr($key, $wordLength), (int) $value);
        }

        return new Event($eventName, $priority, $conditions);
    }
}
