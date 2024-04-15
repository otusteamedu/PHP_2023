<?php

namespace Dmitry\Hw16\Application\Factory;

use Dmitry\Hw16\Domain\Entity\Burger;
use Dmitry\Hw16\Domain\Entity\Product;
use Dmitry\Hw16\Domain\Entity\Sandwich;
use Dmitry\Hw16\Domain\Entity\Hotdog;

class ProductFactory
{
    public function makeFood(string $type): Product
    {
        switch ($type) {
            case 'burger':
                return new Burger();
            case 'sandwich':
                return new Sandwich();
            case 'hotdog':
                return new Hotdog();
            default:
                throw new \Exception('Неизвестный продукт - ' . $type);
                break;
        }
    }
}