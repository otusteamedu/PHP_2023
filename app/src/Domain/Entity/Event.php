<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Domain\Entity;

use Imitronov\Hw12\Domain\ValueObject\Condition;
use Imitronov\Hw12\Domain\ValueObject\EventData;

final class Event
{
    /**
     * @param Condition[] $conditions
     */
    public function __construct(
        private readonly int $id,
        private readonly int $priority,
        private readonly array $conditions,
        private readonly EventData $data,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getData(): EventData
    {
        return $this->data;
    }
}
