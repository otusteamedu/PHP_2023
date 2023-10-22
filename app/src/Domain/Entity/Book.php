<?php

namespace App\Domain\Entity;

class Book
{
    /** @var string */
    private $sku;

    /** @var string */
    private $title;

    /** @var string */
    private $category;

    /** @var int */
    private $price;

    /** @var array */
    private $stock;

    public function __construct(string $sku, string $title, string $category, int $price, array $stock)
    {
        $this->sku = $sku;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku($sku): void
    {
        $this->sku = $sku;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory($category): void
    {
        $this->category = $category;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getStock(): array
    {
        return $this->stock;
    }

    public function setStock($stock): void
    {
        $this->stock = $stock;
    }
}
