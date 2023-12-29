<?php

namespace App\Domain;

readonly class ElementConditions
{
    private ConditionParam $param1;
    private ConditionParam $param2;

    public function __construct(int $val1, int $val2)
    {
        $this->param1 = new ConditionParam($val1);
        $this->param2 = new ConditionParam($val2);
    }

    public function getParam1(): ConditionParam
    {
        return $this->param1;
    }

    public function getParam2(): ConditionParam
    {
        return $this->param2;
    }
}
