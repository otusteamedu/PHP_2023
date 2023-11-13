<?php

declare(strict_types=1);

namespace Gesparo\HW\Application\UseCase\Request;

class ConditionDTO
{
    public function __construct(public readonly string $name, public readonly int $value)
    {
    }
}
