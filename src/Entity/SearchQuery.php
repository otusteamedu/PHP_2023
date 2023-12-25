<?php

namespace Dimal\Hw11\Entity;

class SearchQuery
{
    private ?float $min_price;
    private ?float $max_price;
    private ?string $category;
    private string $title = '';

    public function __construct(string $title, ?string $category = null, ?float $min_price = null, ?float $max_price = null)
    {
        $this->min_price = $min_price;
        $this->max_price = $max_price;
        $this->category = $category;
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMinPrice(): float
    {
        return $this->min_price;
    }

    public function getMaxPrice(): float
    {
        return $this->max_price;
    }

    public function getCategory(): string
    {
        return $this->category;
    }
}