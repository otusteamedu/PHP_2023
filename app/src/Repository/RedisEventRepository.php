<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\EventException;
use App\Model\Event;
use App\Model\EventCondition;
use App\Model\EventData;
use App\Service\RedisClient;

readonly class RedisEventRepository implements EventRepositoryInterface
{
    public function __construct(
        private RedisClient $redisClient,
    ) {
    }

    public function create(Event $event): void
    {
        $hash = $this->createEventHash($event);

        $this->redisClient->set("event:$hash:priority", $event->priority);

        $this->redisClient->hset("event:$hash:data", 'title', $event->data->title);
        $this->redisClient->hset("event:$hash:data", 'data', $event->data->data);
        $this->redisClient->hset("event:$hash:data", 'createdAt', $event->data->createdAt->format('Y-m-d\TH:i:s\Z'));

        foreach ($event->conditions as $condition) {
            $this->redisClient->set("event:$hash:conditions:$condition->key", $condition->value);
            $this->redisClient->sadd("event:conditions:$condition->key:$condition->value", "event:$hash");
        }
    }

    public function clear(): void
    {
        $this->redisClient->deleteAllKeys();
    }

    /**
     * @param EventCondition[] $conditionsDto
     * @return Event[]
     * @throws EventException
     */
    public function findByConditions(array $conditionsDto): array
    {
        $eventsHashes = [];
        foreach ($conditionsDto as $param) {
            $eventsHashes[] = $this->redisClient->smembers("event:conditions:$param->key:$param->value");
        }
        $eventsHashes = array_unique(array_merge(...$eventsHashes));

        return array_map(function (string $hash): Event {
            return $this->getEventByHash($hash);
        }, $eventsHashes);
    }

    /**
     * @throws EventException
     */
    private function getEventByHash(string $hash): Event
    {
        $priority = $this->redisClient->get("$hash:priority");
        if ($priority === false) {
            throw EventException::priorityNotFound();
        }

        $conditionValues = $this->redisClient->getByKeyPattern("$hash:conditions:*");
        $conditions = [];

        foreach ($conditionValues as $key => $value) {
            $condition = str_replace("$hash:conditions:", '', $key);
            $conditions[] = new EventCondition($condition, $value);
        }

        $eventDataValues = $this->redisClient->hGetAll("$hash:data");
        if (
            !array_key_exists('title', $eventDataValues) ||
            !array_key_exists('data', $eventDataValues) ||
            !array_key_exists('createdAt', $eventDataValues)
        ) {
            throw EventException::eventDataNotFound();
        }

        $eventData = new EventData(
            $eventDataValues['title'],
            $eventDataValues['data'],
            new \DateTimeImmutable($eventDataValues['createdAt'])
        );

        return new Event(
            (int)$priority,
            $conditions,
            $eventData,
        );
    }

    private function createEventHash(Event $event): string
    {
        return hash('sha256', json_encode($event, JSON_THROW_ON_ERROR));
    }
}