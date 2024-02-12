<?php

namespace Dimal\Hw11\Domain\ValueObject;

class StockCount
{
    private int $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function getCount(): int
    {
        return $this->count;
    }

}