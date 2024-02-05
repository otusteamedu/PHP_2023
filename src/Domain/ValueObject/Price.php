<?php

namespace Dimal\Hw11\Domain\ValueObject;

class Price
{
    private ?float $price;

    public function __construct(float $price = null)
    {
        $this->price = $price;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getFormattedPrice(): string
    {
        return $this->price ? number_format($this->price, 2, ',', ' ') : '';
    }
}
