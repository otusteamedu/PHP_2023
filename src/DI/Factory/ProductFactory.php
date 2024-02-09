<?php

namespace HW11\Elastic\DI\Factory;

use HW11\Elastic\DI\Product\Product;

// Абстрактная фабрика
interface ProductFactory
{
    public function createProduct(): Product;
}
