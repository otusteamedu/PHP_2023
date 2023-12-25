<?php

namespace App\Application\action\titleCategoryPriceSearch;

use App\Application\action\CriteriaInterface;

class TitleCategoryPriceCriteria implements CriteriaInterface
{
    private string $title;
    private string $category;
    private string $price;

    public function __construct(array $args)
    {
        $this->title = $args[1];
        $this->category = $args[2];
        $this->price = $args[3];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): string
    {
        return $this->price;
    }
}
