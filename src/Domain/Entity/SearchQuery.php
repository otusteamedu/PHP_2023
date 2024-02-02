<?php

namespace Dimal\Hw11\Domain\Entity;

use Dimal\Hw11\Domain\ValueObject\Category;
use Dimal\Hw11\Domain\ValueObject\Price;
use Dimal\Hw11\Domain\ValueObject\Title;

class SearchQuery
{
    private Price $min_price;
    private Price $max_price;
    private Category $category;
    private Title $title;

    public function __construct(
        Title    $title,
        Category $category,
        Price    $min_price,
        Price    $max_price)
    {
        $this->min_price = $min_price;
        $this->max_price = $max_price;
        $this->category = $category;
        $this->title = $title;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getMinPrice(): Price
    {
        return $this->min_price;
    }

    public function getMaxPrice(): Price
    {
        return $this->max_price;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}
