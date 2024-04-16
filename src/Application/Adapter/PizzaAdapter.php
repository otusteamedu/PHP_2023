<?php

namespace Dmitry\Hw16\Application\Adapter;

use Dmitry\Hw16\Domain\Entity\Pizza;
use Dmitry\Hw16\Domain\Entity\ProductInterface;

class PizzaAdapter implements ProductInterface
{
    private ProductInterface $pizza;

    public function __construct()
    {
        $this->createPizza();
    }

    private function createPizza(): void
    {
        $this->pizza = new Pizza();
    }

    public function getName(): string
    {
        return $this->pizza->getName();
    }

    public function makeCooked(): void
    {
        $this->pizza->makeCooked();
    }
}
