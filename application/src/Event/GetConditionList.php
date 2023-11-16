<?php

declare(strict_types=1);

namespace Gesparo\HW\Event;

class GetConditionList
{
    private array $conditions;

    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }

    public function getAll(): array
    {
        return $this->conditions;
    }
}
