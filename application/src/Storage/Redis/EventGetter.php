<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\Redis;

use Gesparo\HW\Event\Event;
use Gesparo\HW\Event\GetConditionList;

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
        $result = [];

        $result[Event::PRIORITY] = (int) $eventData['priority'];
        $result[Event::EVENT] = $eventData['event'];

        unset($eventData['priority'], $eventData['event']);

        $wordLength = strlen('condition:');

        foreach ($eventData as $key => $value) {
            $result[Event::CONDITIONS][substr($key, $wordLength)] = $value;
        }

        return new Event($result);
    }
}
