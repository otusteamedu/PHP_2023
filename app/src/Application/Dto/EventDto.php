<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Dto;

final class EventDto
{
    /**
     * @param ConditionDto[] $conditions
     */
    public function __construct(
        public readonly int $priority,
        public readonly array $conditions,
        public readonly EventDataDto $data,
    ) {
    }
}
