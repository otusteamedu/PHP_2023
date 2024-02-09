<?php

namespace HW11\Elastic\DI\Product;

interface Product
{
    public function prepare(): void;
    public function getName(): string;
    public function getPrice(): float;
}
