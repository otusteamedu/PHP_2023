<?php

declare(strict_types=1);

namespace AYamaliev\hw12\Infrastructure\Repository;

use AYamaliev\hw12\Application\Dto\SearchDto;
use Redis;
use AYamaliev\hw12\Domain\Entity\Event;
use AYamaliev\hw12\Application\Repository\RepositoryInterface;
use ReflectionClass;

class RedisRepository implements RepositoryInterface
{
    private Redis $client;
    const DB_NAME = 'events';

    public function __construct()
    {
        $this->client = new Redis();
        $this->client->connect('redis-hw12');
    }

    public function add(Event $event): void
    {
        $this->client->zAdd(self::DB_NAME, $event->getPriority(), $event->getEvent());

        if ($event->getParam1()) {
            $this->client->hSet($event->getEvent(), 'param1', $event->getParam1());
        }

        if ($event->getParam2()) {
            $this->client->hSet($event->getEvent(), 'param2', $event->getParam2());
        }
    }

    public function clear(): void
    {
        $this->client->flushDB();
    }

    public function get(SearchDto $searchDto): ?Event
    {
        $conditions = $this->getConditions($searchDto);
        $events = $this->client->zRevRange(self::DB_NAME, 0, -1);

        foreach ($events as $eventName) {
            foreach ($conditions as $paramName => $paramValue) {
                if (
                    !$this->client->hExists($eventName, (string)$paramName)
                    || $this->client->hGet($eventName, $paramName) != $paramValue
                ) {
                    continue 2;
                }
            }

            return new Event(
                (int)$this->client->zScore(self::DB_NAME, $eventName),
                $eventName,
                $this->client->hExists($eventName, 'param1') ? $this->client->hGet($eventName, 'param1') : null,
                $this->client->hExists($eventName, 'param2') ? $this->client->hGet($eventName, 'param2') : null,
            );
        }

        return null;
    }

    public function getAll(): array
    {
        $events = $this->client->zRange(self::DB_NAME, 0, -1);
        $outputData = [];

        foreach ($events as $eventName) {
            $outputData[] = new Event(
                (int)$this->client->zScore(self::DB_NAME, $eventName),
                $eventName,
                $this->client->hExists($eventName, 'param1') ? $this->client->hGet($eventName, 'param1') : null,
                $this->client->hExists($eventName, 'param2') ? $this->client->hGet($eventName, 'param2') : null,
            );
        }

        return $outputData;
    }

    private function getConditions(SearchDto $searchDto): array
    {
        $conditions = [];
        $reflection = new ReflectionClass($searchDto);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            if ($property->getValue($searchDto)) {
                $conditions[$property->getName()] = $property->getValue($searchDto);
            }
        }

        return $conditions;
    }
}
