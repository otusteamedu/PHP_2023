<?php

namespace YakovGulyuta\Hw15\Application\Dto;

use YakovGulyuta\Hw15\Domain\ValueObject\Name;

class CreateCinemaRequest
{
    public Name $name;

    public function __construct(Name $name)
    {
        $this->name = $name;
    }
}
