<?php

declare(strict_types=1);

namespace Otus\App\EventSourcing\Infrastructure\Repository;

use Otus\App\EventSourcing\Domain\Model\Event;
use Otus\App\EventSourcing\Domain\Repository\EventRepositoryInterface;
use Predis\ClientInterface;

final readonly class EventRepository implements EventRepositoryInterface
{
    public function __construct(
        private ClientInterface $redis,
    ) {
    }

    public function add(Event $event, int $priority, string $conditions): void
    {
        $this->redis->zadd($conditions, [$event->getId() => $priority]);
        $this->redis->set((string) $event->getId(), serialize($event));
    }
}
