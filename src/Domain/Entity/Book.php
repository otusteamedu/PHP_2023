<?php

namespace Dimal\Hw11\Domain\Entity;

use Dimal\Hw11\Domain\ValueObject\Category;
use Dimal\Hw11\Domain\ValueObject\Id;
use Dimal\Hw11\Domain\ValueObject\Price;
use Dimal\Hw11\Domain\ValueObject\Title;

class Book
{
    private Id $id;
    private Title $title;
    private Category $category;
    private Price $price;
    private array $stockCount;

    public function __construct(
        Id       $id,
        Title    $title,
        Category $category,
        Price    $price,
        array    $stockCount
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->stockCount = $stockCount;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getStockCount(): array
    {
        return $this->stockCount;
    }

}
