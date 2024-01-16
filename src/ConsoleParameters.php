<?php

namespace HW11\Elastic;

class ConsoleParameters
{
    private $searchTerm;
    private $category;
    private $price;
    private $stockQuantity;
    public function __construct(array $options)
    {
        $this->searchTerm = $options['s'] ?? null;
        $this->category = $options['c'] ?? null;
        $this->price = $options['p'] ?? null;
        $this->stockQuantity = $options['q'] ?? null;
    }
    public function getSearchTerm()
    {
        return $this->searchTerm;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }
}
