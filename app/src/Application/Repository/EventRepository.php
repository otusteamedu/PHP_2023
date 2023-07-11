<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Repository;

use Imitronov\Hw12\Domain\ValueObject\Condition;
use Imitronov\Hw12\Domain\Entity\Event;

interface EventRepository
{
    public function nextId(): int;

    public function deleteAll(): void;

    public function create(Event $event): Event;

    /**
     * @param Condition[] $conditions
     * @return Event[]
     */
    public function allByConditions(array $conditions): array;
}
