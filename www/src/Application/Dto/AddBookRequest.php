<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application\Dto;

/**
 * AddBookRequest
 */
class AddBookRequest {
    public string $sku;
    public string $title;
    public string $category;
    public float $price;
    public array $stock;
    public string $id;
    
    /**
     * @param $sku
     * @param $title
     * @param $category
     * @param $price
     * @param $stock
     * @param string $id
     */
    public function __construct(
        $sku,
        $title,
        $category,
        $price,
        $stock,
        string $id = ''
    )
    {
        $this->sku = $sku;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
        $this->id = $id;
    }
}