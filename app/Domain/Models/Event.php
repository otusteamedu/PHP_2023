<?php

declare(strict_types=1);

namespace App\Domain\Models;

use JsonException;

class Event
{
    public const KEY = 'event';
    public const NAME = 'name';
    public const PRIORITY = 'priority';
    public const CONDITIONS = 'conditions';

    /**
     * @var string
     */
    protected string $id;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var int
     */
    protected int $priority;

    /**
     * @var string
     */
    protected string $conditions;

    /**
     * @throws JsonException
     */
    public function __construct(array $event)
    {
        $this->setId(uniqid(self::KEY, true));
        $this->setName($event['event']);
        $this->setPriority((int) $event['priority']);
        $this->setConditions(json_encode($event['conditions'], JSON_THROW_ON_ERROR));
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param  string  $id
     */
    public function setId(string $id): void
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
     * @param  string  $name
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
     * @param  int  $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getConditions(): string
    {
        return $this->conditions;
    }

    /**
     * @param  string  $conditions
     */
    public function setConditions(string $conditions): void
    {
        $this->conditions = $conditions;
    }
}
