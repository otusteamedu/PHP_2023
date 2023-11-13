<?php

declare(strict_types=1);

namespace Gesparo\HW\Application\UseCase\Request;

class GetEventRequest
{
    /**
     * @param ConditionDTO[] $conditions
     */
    public function __construct(public readonly array $conditions)
    {
    }
}
