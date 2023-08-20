<?php

namespace App\Repository;

use App\Model\Event;
use App\Model\EventCondition;

interface EventRepositoryInterface
{
    public function create(Event $event): void;

    public function clear(): void;

    /**
     * @param EventCondition[] $conditionsDto
     * @return Event[]
     */
    public function findByConditions(array $conditionsDto): array;
}