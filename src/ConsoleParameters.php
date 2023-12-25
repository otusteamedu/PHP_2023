<?php

namespace HW11\Elastic;

class ConsoleParameters
{
    public array $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getSearchTerm(): ?string
    {
        return $this->parameters['s'] ?? null;
    }

    public function getCategory(): ?string
    {
        return $this->parameters['c'] ?? null;
    }

    public function getPrice(): ?string
    {
        return $this->parameters['p'] ?? null;
    }

    public function getStockQuantity(): ?string
    {
        return $this->parameters['q'] ?? null;
    }
}