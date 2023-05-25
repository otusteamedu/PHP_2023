<?php

namespace YakovGulyuta\Hw15\Domain\ValueObject;

class Name
{

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}