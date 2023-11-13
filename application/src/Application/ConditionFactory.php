<?php

declare(strict_types=1);

namespace Gesparo\HW\Application;

use Gesparo\HW\Domain\ValueObject\Condition;

class ConditionFactory
{
    public function create(string $name, int $value): Condition
    {
        return new Condition($name, $value);
    }
}
