<?php

declare(strict_types=1);

namespace App\Model;

readonly class Event
{
    public function __construct(
        public int $priority,
        /** @var EventCondition[] */
        public array $conditions,
        public EventData $data,
    ) {
    }
}
