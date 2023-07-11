<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Repository;

use Imitronov\Hw12\Application\Repository\EventRepository;
use Imitronov\Hw12\Domain\Entity\Event;
use Imitronov\Hw12\Domain\ValueObject\Condition;
use Imitronov\Hw12\Infrastructure\Component\RedisClient;

final class RedisEventRepository implements EventRepository
{
    const INDEX_INCREMENT = 'events_increment';

    const EVENTS_PREFIX = 'events';

    const CONDITIONS_PREFIX = 'conditions';

    const UNION_PREFIX = 'union';

    public function __construct(
        private readonly RedisClient $redisClient,
    ) {
    }

    public function nextId(): int
    {
        if (!$this->redisClient->getRedis()->exists(self::INDEX_INCREMENT)) {
            $this->redisClient->getRedis()->set(self::INDEX_INCREMENT, "0");
        }

        return (int) $this->redisClient
            ->getRedis()
            ->incr(self::INDEX_INCREMENT);
    }

    public function firstById(int $id): ?Event
    {
        /** @var string|null $serializedEvent */
        $serializedEvent = $this->redisClient
            ->getRedis()
            ->get(sprintf('%s:%s', self::EVENTS_PREFIX, $id));

        if (false !== $serializedEvent) {
            return unserialize($serializedEvent);
        }

        return null;
    }

    public function create(Event $event): Event
    {
        $this->redisClient->getRedis()->set(
            sprintf('%s:%s', self::EVENTS_PREFIX, $event->getId()),
            serialize($event),
        );

        $conditionKeys = array_map(
            static fn ($condition) => sprintf(
                '%s_%s',
                $condition->getKey(),
                $condition->getValue(),
            ),
            $event->getConditions(),
        );
        sort($conditionKeys);
        $key = sprintf(
            '%s:%s',
            self::CONDITIONS_PREFIX,
            implode(':', $conditionKeys),
        );

        $this
            ->redisClient
            ->getRedis()
            ->zAdd(
                $key,
                $event->getPriority(),
                $event->getId(),
            );

        return $event;
    }

    /**
     * @param Condition[] $conditions
     */
    public function allByConditions(array $conditions): array
    {
        if (count($conditions) === 0) {
            return [];
        }

        $events = [];
        $conditionKeys = array_map(
            static fn ($condition) => sprintf(
                '%s_%s',
                $condition->getKey(),
                $condition->getValue(),
            ),
            $conditions,
        );
        $keys = array_map(
            static fn ($condition) => sprintf(
                '%s:%s_%s',
                self::CONDITIONS_PREFIX,
                $condition->getKey(),
                $condition->getValue(),
            ),
            $conditions,
        );
        $keys[] = sprintf(
            '%s:%s',
            self::CONDITIONS_PREFIX,
            implode(':', $conditionKeys),
        );
        sort($keys);
        $zUnionStoreKey = sprintf(
            '%s:%s',
            self::UNION_PREFIX,
            implode(':', $keys),
        );

        $this->redisClient
            ->getRedis()
            ->zUnionStore($zUnionStoreKey, $keys);

        $eventIds = $this->redisClient
            ->getRedis()
            ->zRevRangeByScore($zUnionStoreKey, '+inf', '-inf');

        foreach ($eventIds as $id) {
            $events[] = $this->firstById((int) $id);
        }

        return array_filter($events, static fn ($event) => null !== $event);
    }

    public function deleteAll(): void
    {
        $keys = $this->redisClient
            ->getRedis()
            ->keys(sprintf('%s:*', self::EVENTS_PREFIX));

        foreach ($keys as $key) {
            $this->redisClient
                ->getRedis()
                ->del($key);
        }

        $keys = $this->redisClient
            ->getRedis()
            ->keys(sprintf('%s:*', self::CONDITIONS_PREFIX));

        foreach ($keys as $key) {
            $this->redisClient
                ->getRedis()
                ->del($key);
        }

        $keys = $this->redisClient
            ->getRedis()
            ->keys(sprintf('%s:*', self::UNION_PREFIX));

        foreach ($keys as $key) {
            $this->redisClient
                ->getRedis()
                ->del($key);
        }
    }
}
