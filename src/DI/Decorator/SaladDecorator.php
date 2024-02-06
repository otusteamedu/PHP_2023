<?php

namespace HW11\Elastic\DI\Decorator;
// Декоратор
class SaladDecorator extends ProductDecorator {
    public function prepare(): void {
        parent::prepare();
        echo "Добавление салата в продукт\n";
    }
    /**
     * @return string
     */
    public function getName(): string {
        return $this->product->getName() . ', Салат';
    }
    /**
     * @return float
     */
    public function getPrice(): float {
        return $this->product->getPrice() + 1.5; // Дополнительная цена за салат
    }
}
