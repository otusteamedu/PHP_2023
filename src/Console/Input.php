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

    private function getQuery()
    {
        return $this->parameters['q'] ?? null;
    }

    private function getCategory()
    {
        return $this->parameters['c'] ?? null;
    }

    private function getPrice()
    {
        return $this->parameters['l'] ?? null;
    }

    public function getSearchParameters(): array
    {
        $must = [];
        $filter = [];

        if ($this->getQuery()) {
            $must['match']['title']['query'] = $this->getQuery();
            $must['match']['title']['fuzziness'] = 'auto';
        }

        if ($this->getCategory()) {
            $filter['match']['category'] = $this->getCategory();
        }

        if ($this->getPrice()) {
            $filter['range']['price']['lte'] = $this->getPrice();
        }

        return [$filter, $must];
    }
}
