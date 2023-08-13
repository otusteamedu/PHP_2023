<?php

declare(strict_types=1);

namespace Ro\Php2023\Entities;

use Ro\Php2023\Collections\ConditionsInterface;

interface EventInterface
{
    public function getPriority(): int;
    public function getConditions(): ConditionsInterface;

    public function getEvent(): array;
}
