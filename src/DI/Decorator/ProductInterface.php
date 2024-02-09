<?php

namespace HW11\Elastic\DI\Decorator;

use HW11\Elastic\DI\Product\Product;

// Изменил на интерфейс, его расположение не стал менять, т.к не считаю нужным выносить его в другое место если он относится к декоратору и не создавать лишнюю директорию.
interface ProductInterface extends Product
{
    public function prepare(): void;
    public function getName(): string;
    public function getPrice(): float;
}
