<?php

namespace App\Patterns\Builder;


use App\Products\ProductInterface;
use Exception;

class OrderBuilder implements OrderBuilderInterface
{
    /**
     * @var array Список продуктов в заказе.
     */
    private array $products = [];

    /**
     * Добавить продукт в заказ.
     *
     * @param ProductInterface $product Продукт для добавления.
     * @return $this
     */
    public function addProduct(ProductInterface $product): OrderBuilderInterface
    {
        $this->products[] = [
            'product' => $product,
            'ingredients' => []
        ];

        return $this;
    }

    /**
     * Добавить ингредиент к последнему добавленному продукту.
     *
     * @param string $ingredient Ингредиент для добавления.
     * @return $this
     * @throws Exception
     */
    public function addIngredient(string $ingredient): OrderBuilderInterface
    {
        if (empty($this->products)) {
            throw new Exception("Невозможно добавить ингредиент без продукта.");
        }

        $lastProductKey = array_key_last($this->products);
        $this->products[$lastProductKey]['ingredients'][] = $ingredient;

        return $this;
    }

    /**
     * Получить итоговый заказ.
     *
     * @return array Возвращает составленный заказ.
     */
    public function getOrder(): array
    {
        return $this->products;
    }
}