<?php

namespace App\Application\Dto;

final class ConditionsDto
{
    public function __construct(private readonly array $params)
    {
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
