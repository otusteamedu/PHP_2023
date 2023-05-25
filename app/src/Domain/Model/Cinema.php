<?php

namespace YakovGulyuta\Hw15\Domain\Model;

class Cinema
{

    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

}