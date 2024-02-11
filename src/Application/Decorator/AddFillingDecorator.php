<?php

declare(strict_types=1);

namespace src\Application\Decorator;

use src\Domain\Entity\Food\FoodInterface;

class AddFillingDecorator implements FoodInterface
{

    public function __construct(
        private FoodInterface $food,
        private string        $newIngredients
    )
    {
    }

    public function getDough(): string
    {
        return $this->food->getDough();
    }

    public function getFilling(): string
    {
        return $this->food->getFilling() . $this->newIngredients;
    }

    public function getName(): string
    {
        return $this->food->getName();
    }

    public function wrap(): string
    {
        return $this->food->wrap();
    }
}
