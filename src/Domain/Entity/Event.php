<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Condition;
use App\Domain\ValueObject\Occasion;

class Event
{
    /**
     * @param Condition[] $conditions
     * @param Occasion[]     $event
     */
    public function __construct(
        private int   $priority,
        private array $conditions,
        private array $event,
    ) {
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getEvent(): array
    {
        return $this->event;
    }

    public function setEvent(array $event): self
    {
        $this->event = $event;

        return $this;
    }
}
