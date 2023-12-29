<?php

namespace App\Domain;

readonly class ConditionParam
{
    private int $val;

    public function __construct (int $val)
    {
        $this->val = $val;
    }

    public function getValue(): int
    {
        return $this->val;
    }
}
