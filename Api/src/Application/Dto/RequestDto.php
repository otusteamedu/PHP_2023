<?php

namespace App\Application\Dto;

readonly class RequestDto
{
    public function __construct(private string $number)
    {
    }

    public function getNumber(): string
    {
        return $this->number;
    }
}
