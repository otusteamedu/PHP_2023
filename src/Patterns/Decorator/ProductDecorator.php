<?php

namespace App\Patterns\Decorator;

use App\Products\ProductInterface;

abstract class ProductDecorator implements ProductInterface
{
    /**
     * @var ProductInterface
     */
    protected ProductInterface $product;

    /**
     * Конструктор декоратора продукта.
     *
     * @param ProductInterface $product Оборачиваемый продукт.
     */
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * Получить название продукта.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->product->getName();
    }

    /**
     * Получить цену продукта.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->product->getPrice();
    }

    /**
     * Получить список ингредиентов продукта.
     *
     * @return array
     */
    public function getIngredients(): array
    {
        return $this->product->getIngredients();
    }
}