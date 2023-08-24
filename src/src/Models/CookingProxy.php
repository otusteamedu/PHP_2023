<?php

namespace App\Models;

use App\Models\Products\Product;
use App\Models\Observer;

class CookingProxy implements Product
{
    private $product;
    private $observer;

    public function __construct(Product $product, Observer $observer)
    {
        $this->product = $product;
        $this->observer = $observer;
    }

    public function getDescription(): string
    {
        return $this->product->getDescription();
    }

    public function cook()
    {
        $this->observer->update("Готовка началась");

        // Здесь происходит процесс готовки

        if ($this->isStandard()) {
            $this->observer->update("Готовка завершена");
        } else {
            $this->utilize();
            $this->observer->update("Готовка завершена (продукт утилизирован)");
        }
    }

    protected function isStandard(): bool
    {
        // Проверка соответствия продукта стандартам
        return true; // Здесь может быть логика проверки
    }

    protected function utilize()
    {
        // Логика утилизации продукта
    }
}
