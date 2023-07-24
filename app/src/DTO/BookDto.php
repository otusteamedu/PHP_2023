<?php

declare(strict_types=1);

namespace YuzyukRoman\Hw11\DTO;

class BookDto
{
    public string $title;
    public string $sku;
    public string $category;
    public float $price;
    public string $shop;
    public int $stockAmount;

    public function __construct(string $title, string $sku, string $category, float $price, string $shop, int $stockAmount)
    {
        $this->title = $title;
        $this->sku = $sku;
        $this->category = $category;
        $this->price = $price;
        $this->shop = $shop;
        $this->stockAmount = $stockAmount;
    }
}
