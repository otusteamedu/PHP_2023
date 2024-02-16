<?php

namespace App\Patterns\Builder;

use App\Products\ProductInterface;

interface OrderBuilderInterface
{
    /**
     * Добавить продукт в заказ.
     *
     * @param ProductInterface $product Продукт для добавления в заказ.
     * @return OrderBuilderInterface Возвращает себя для цепочки вызовов.
     */
    public function addProduct(ProductInterface $product): self;

    /**
     * Добавить ингредиент к последнему добавленному продукту в заказе.
     *
     * @param string $ingredient Название ингредиента для добавления.
     * @return OrderBuilderInterface Возвращает себя для цепочки вызовов.
     */
    public function addIngredient(string $ingredient): self;

    /**
     * Получить итоговый заказ.
     *
     * @return mixed Возвращает собранный заказ.
     */
    public function getOrder();
}