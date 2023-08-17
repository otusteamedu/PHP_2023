<?php

declare(strict_types=1);

namespace Neunet\App\Models;

class Event
{
    private int $priority;
    private array $conditions;

    public function __construct(int $priority, array $conditions)
    {
        $this->priority = $priority;
        $this->conditions = $conditions;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @param array $conditions
     */
    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }

    public function print(): string
    {
        return json_encode([
            'priority' => $this->priority,
            'conditions' => $this->conditions
        ]);
    }
}
