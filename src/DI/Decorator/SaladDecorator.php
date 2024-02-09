<?php

namespace HW11\Elastic\DI\Decorator;

// Декоратор
class SaladDecorator implements ProductInterface
{
    protected ProductInterface $product;
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }
    public function prepare(): void
    {
        $this->product->prepare();
        echo "Добавление салата в продукт\n";
    }
    public function getName(): string
    {
        return $this->product->getName() . ', Салат';
    }
    public function getPrice(): float
    {
        return $this->product->getPrice() + 1.5; // Дополнительная цена за салат
    }
}
