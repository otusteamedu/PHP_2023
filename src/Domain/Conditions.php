<?php

declare(strict_types=1);

namespace src\Domain;

class Conditions
{
    private ?int $param1;
    private ?int $param2;

    public function __construct(?int $param1, ?int $param2)
    {
        $this->param1 = $param1;
        $this->param2 = $param2;
    }

    public function getParam1(): ?int
    {
        return $this->param1;
    }

    public function getParam2(): ?int
    {
        return $this->param2;
    }
}
