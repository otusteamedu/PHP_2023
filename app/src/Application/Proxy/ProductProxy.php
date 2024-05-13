<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Application\Proxy;

use AYamaliev\Hw16\Domain\Entity\Product;
use AYamaliev\Hw16\Domain\Entity\ProductInterface;

class ProductProxy extends Product implements ProductInterface
{
    public function __construct(private ProductInterface $product)
    {
        parent::__construct($product->getTitle(), $product->getPrice());
    }

    public function getTitle(): string
    {
        return $this->product->getTitle();
    }

    public function getPrice(): float
    {
        return $this->product->getPrice();
    }

    public function cook(): void
    {
        $this->preEvent();
        echo "Приготовление {$this->getTitle()}" . PHP_EOL;
        $this->postEvent();
    }

    private function preEvent(): void
    {
        echo "Начало приготовления {$this->getTitle()}" . PHP_EOL;
    }

    private function postEvent(): void
    {
        echo "Конец приготовления {$this->getTitle()}" . PHP_EOL;
    }
}
