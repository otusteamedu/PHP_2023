<?php

declare(strict_types=1);

namespace Otus\App\EventProvider;

use Otus\App\Entity\Condition;
use Otus\App\Entity\Event;
use Predis\Client;

final readonly class RedisEventProvider implements EventProviderInterface
{
    public function __construct(
        private Client $redis,
    ) {
    }

    /**
     * @param array<Condition> $conditions
     */
    public function add(Event $event, int $priority, Condition ...$conditions): void
    {
        $encodedConditions = $this->hydrate($conditions);

        $this->redis->zadd($encodedConditions, [$event->getId() => $priority]);
        $this->redis->set((string) $event->getId(), serialize($event));
    }

    public function mostSuitableEvent(Condition ...$conditions): Event
    {
        $encodedConditions = $this->hydrate($conditions);

        $eventIds = $this->redis->zrange($encodedConditions, 0, -1);

        $bestEventId = array_pop($eventIds);
        $bestEvent = $this->redis->get($bestEventId);

        return unserialize($bestEvent);
    }

    public function clear(): void
    {
        $this->redis->flushdb();
    }

    /**
     * @param array<Condition> $conditions
     */
    private function hydrate(array $conditions): string
    {
        if (empty($conditions)) {
            throw new \LogicException('You must have at least one condition');
        }

        $params = [];

        foreach ($conditions as $condition) {
            $params[] = "{$condition->getKey()}:{$condition->getValue()}";
        }

        return implode(':', $params);
    }
}
