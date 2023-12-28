<?php

declare(strict_types=1);

namespace App\Console;

class Input
{
    private array $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getQuery()
    {
        return $this->parameters['q'] ?? null;
    }

    public function getCategory()
    {
        return $this->parameters['c'] ?? null;
    }

    public function getPrice()
    {
        return $this->parameters['l'] ?? null;
    }
}
