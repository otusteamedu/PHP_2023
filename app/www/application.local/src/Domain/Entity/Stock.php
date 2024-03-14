<?php

declare(strict_types=1);

namespace AYamaliev\hw11\Domain\Entity;

class Stock
{
    public function __construct(private string $shop, private int $stock)
    {
    }

    /**
     * @return string
     */
    public function getShop(): string
    {
        return $this->shop;
    }

    /**
     * @param string $shop
     */
    public function setShop(string $shop): void
    {
        $this->shop = $shop;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }
}
