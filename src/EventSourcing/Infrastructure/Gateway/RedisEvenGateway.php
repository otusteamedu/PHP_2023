<?php

declare(strict_types=1);

namespace Otus\App\EventSourcing\Infrastructure\Gateway;

use Otus\App\EventSourcing\Application\Contract\EventGatewayInterface;
use Otus\App\EventSourcing\Domain\Model\Condition;
use Otus\App\EventSourcing\Domain\Model\Event;
use Otus\App\EventSourcing\Domain\Repository\EventRepositoryInterface;
use Otus\App\Hydrator\Domain\Contract\HydratorInterface;

final readonly class RedisEvenGateway implements EventGatewayInterface
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private HydratorInterface $hydrator,
    ) {
    }

    /**
     * @param Condition[] $conditions
     */
    public function add(Event $event, int $priority, array $conditions): void
    {
        $encodedConditions = $this->hydrator->hydrate($conditions);

        $this->eventRepository->add($event, $priority, $encodedConditions);
    }
}
