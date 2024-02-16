<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\Adapter;

use Patterns\Daniel\Products\Pizza;
use Patterns\Daniel\Products\ProductInterface;

class PizzaAdapter implements ProductInterface
{
    /**
     * @var Pizza
     */
    private Pizza $pizza;

    public function __construct(Pizza $pizza)
    {
        $this->pizza = $pizza;
    }

    public function getName(): string
    {
        return $this->pizza->getPizzaName();
    }

    public function getPrice(): float
    {
        return $this->pizza->getPizzaPrice();
    }

    public function getIngredients(): array
    {
        return $this->pizza->getPizzaIngredients();
    }
}