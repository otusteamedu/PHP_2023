<?php

namespace Dimal\Hw12;

class EventConditions
{
    private array $conditions;

    public function __construct($conditions)
    {
        $this->conditions = $conditions;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

}