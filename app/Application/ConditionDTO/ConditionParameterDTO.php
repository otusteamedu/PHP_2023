<?php

namespace App\Application\ConditionDTO;

class ConditionParameterDTO
{
    private array $data;
    private const KEY_PARAM_1 = 'p1';
    private const KEY_PARAM_2 = 'p2';

    public function __construct(
        int $param1,
        int $param2,
    ) {
        $this->data[$this::KEY_PARAM_1] = $param1;
        $this->data[$this::KEY_PARAM_2] = $param2;
    }

    public function getParam1(): int
    {
        return $this->data[$this::KEY_PARAM_1];
    }

    public function getParam2(): int
    {
        return $this->data[$this::KEY_PARAM_2];
    }
}
