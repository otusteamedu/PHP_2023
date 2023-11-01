<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\Redis;

use Gesparo\HW\Event\Event;

class EventSetter
{
    use ConditionNameTrait;

    private \Redis $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws \RedisException
     * @throws \Exception
     */
    public function set(Event $event): void
    {
        $eventName = $this->getEventName();
        $hashResult = $this->redis->hMSet($eventName, $this->getHashData($event));

        if ($hashResult === false) {
            throw RedisStorageException::cannotSetEventData($eventName);
        }

        $setResult = $this->redis->zAdd(
            $this->getConditionNameFromEvent($event),
            $event->getPriority(),
            $eventName
        );

        if ($setResult === false) {
            throw RedisStorageException::cannotAddEventToSet($eventName, $this->getConditionNameFromEvent($event));
        }
    }

    private function getHashData(Event $event): array
    {
        $result = [
            'event' => $event->getEvent(),
            'priority' => $event->getPriority(),
        ];

        foreach ($event->getConditions() as $key => $value) {
            $result["condition:$key"] = $value;
        }

        return $result;
    }

    /**
     * @throws \Exception
     */
    private function getEventName(): string
    {
        $random = random_int(0, 1000000);
        return "event:$random";
    }

    private function getConditionNameFromEvent(Event $event): string
    {
        $eventConditions = $event->getConditions();

        return $this->getConditionName($eventConditions);
    }
}