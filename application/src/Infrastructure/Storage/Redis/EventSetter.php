<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Redis;

use Gesparo\HW\Domain\Entity\Event;

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
            $event->getPriority()->getValue(),
            $eventName
        );

        if ($setResult === false) {
            throw RedisStorageException::cannotAddEventToSet($eventName, $this->getConditionNameFromEvent($event));
        }
    }

    private function getHashData(Event $event): array
    {
        $result = [
            'event' => $event->getName()->getValue(),
            'priority' => $event->getPriority()->getValue(),
        ];

        foreach ($event->getConditions() as $condition) {
            $result["condition:{$condition->getName()}"] = $condition->getValue();
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
