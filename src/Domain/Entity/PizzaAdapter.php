<?php

declare(strict_types=1);

namespace src\Domain\Entity;

use src\Domain\Entity\Food\FoodInterface;

class PizzaAdapter extends Pizza implements FoodInterface
{
    public function getDough(): string
    {
        return $this->getSpecialPizzaDough();
    }

    public function getFilling(): string
    {
        return $this->getSpecialPizzaFilling();
    }

    public function getName(): string
    {
        return $this->getNameFood();
    }

    public function wrap(): string
    {
        return $this->wrapInSpecialBox();
    }
}
