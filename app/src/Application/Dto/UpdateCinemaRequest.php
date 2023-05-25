<?php

namespace YakovGulyuta\Hw15\Application\Dto;

use YakovGulyuta\Hw15\Domain\ValueObject\Name;

class UpdateCinemaRequest
{
    public Name $name;

    public int $cinema_id;

    public function __construct(Name $name, int $cinema_id)
    {
        $this->name = $name;
        $this->cinema_id = $cinema_id;
    }

}