<?php

namespace Ro\Php2023\Collections;

use Countable;
use IteratorAggregate;
use Ro\Php2023\Entities\ConditionInterface;

interface ConditionsInterface extends Countable, IteratorAggregate
{
    public function add(ConditionInterface $item): self;
    public function toArray(): array;
}
