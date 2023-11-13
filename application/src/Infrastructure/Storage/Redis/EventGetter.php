<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Redis;

use Gesparo\HW\Application\ConditionFactory;
use Gesparo\HW\Application\EventFactory;
use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\List\GetConditionList;

class EventGetter
{
    use ConditionNameTrait;

    private \Redis $redis;
    private EventFactory $eventFactory;
    private ConditionFactory $conditionFactory;

    public function __construct(\Redis $redis, EventFactory $eventFactory, ConditionFactory $conditionFactory)
    {
        $this->redis = $redis;
        $this->eventFactory = $eventFactory;
        $this->conditionFactory = $conditionFactory;
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
        $priority = (int) $eventData['priority'];
        $eventName = $eventData['event'];

        unset($eventData['priority'], $eventData['event']);

        $wordLength = strlen('condition:');

        $conditions = [];

        foreach ($eventData as $key => $value) {
            $conditions[] = $this->conditionFactory->create(substr($key, $wordLength), (int) $value);
        }

        return $this->eventFactory->create($eventName, $priority, $conditions);
    }
}
