<?php

declare(strict_types=1);

namespace Gesparo\HW\Application\UseCase\Request;

class EventDTO
{
    /**
     * @param string $name
     * @param int $priority
     * @param ConditionDTO[] $conditions
     */
    public function __construct(
        public readonly string $name,
        public readonly int $priority,
        public readonly array $conditions
    ) {
    }
}
