<?php

declare(strict_types=1);

namespace Ro\Php2023\Collections;

use ArrayIterator;
use Ro\Php2023\Entities\ConditionInterface;

class Conditions implements ConditionsInterface
{
    protected array $items = [];

    public function add(ConditionInterface $item): ConditionsInterface
    {
        $this->items[] = $item;
        return $this;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function toArray(): array
    {
        $result = [];
        $it = $this->getIterator();

        while ($it->valid())
        {
            $result[$it->current()->getName()] = $it->current()->getValue();
            $it->next();
        }

        return $result;
    }
}
