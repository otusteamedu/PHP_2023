<?php

declare(strict_types=1);

namespace Vp\App\DTO;

class SearchParams
{
    private ?string $query;
    private ?string $category;
    private ?string $maxPrice;

    public function __construct(?string $query = null, ?string $category = null, ?string $maxPrice = null)
    {
        $this->query = $query;
        $this->category = $category;
        $this->maxPrice = $maxPrice;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getMaxPrice(): ?string
    {
        return $this->maxPrice;
    }
}
