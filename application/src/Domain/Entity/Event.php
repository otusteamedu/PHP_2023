<?php

declare(strict_types=1);

namespace Gesparo\HW\Domain\Entity;

use Gesparo\HW\Domain\ValueObject\Condition;
use Gesparo\HW\Domain\ValueObject\Name;
use Gesparo\HW\Domain\ValueObject\Priority;

class Event
{
    private Name $name;
    private Priority $priority;
    /**
     * @var Condition[]
     */
    private array $conditions;

    /**
     * @param Name $name
     * @param Priority $priority
     * @param Condition[] $conditions
     */
    public function __construct(Name $name, Priority $priority, array $conditions)
    {
        $this->name = $name;
        $this->priority = $priority;
        $this->conditions = $conditions;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): Event
    {
        $this->name = $name;
        return $this;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function setPriority(Priority $priority): Event
    {
        $this->priority = $priority;
        return $this;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function setConditions(array $conditions): Event
    {
        $this->conditions = $conditions;
        return $this;
    }
}
