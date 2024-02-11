<?php

declare(strict_types=1);

namespace src\Domain\Entity;

class Pizza
{
    private string $specialPizzaDough;
    private string $specialPizzaFilling;

    public function __construct(string $specialPizzaFilling)
    {
        $this->specialPizzaDough = 'Special pizza dough';
        $this->specialPizzaFilling = $specialPizzaFilling;
    }

    public function getSpecialPizzaDough(): string
    {
        return $this->specialPizzaDough;
    }

    public function getSpecialPizzaFilling(): string
    {
        return $this->specialPizzaFilling;
    }

    public function getNameFood(): string
    {
        return get_class($this);
    }

    public function wrapInSpecialBox(): string
    {
        return 'Упаковать пиццу в картонную коробку';
    }
}
