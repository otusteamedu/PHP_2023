<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Conditions;

class Event
{
    private ?int $id = null;
    private int $priority;
    private string $name;
    private ?Conditions $conditions;

    public function __construct(int $priority = 0, string $name = '', ?Conditions $conditions = null)
    {
        $this->priority = $priority;
        $this->name = $name;
        $this->conditions = $conditions;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     * @return Conditions
     */
    public function getConditions(): Conditions
    {
        return $this->conditions;
    }

    /**
     * @param Conditions $conditions
     */
    public function setConditions(Conditions $conditions): void
    {
        $this->conditions = $conditions;
    }
}
