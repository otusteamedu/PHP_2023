<?php

declare(strict_types=1);

namespace src\Domain\Entity\Food;

abstract class FoodAbstract implements FoodInterface
{
    private string $dough;
    private string $filling;

    public function __construct(string $dough, string $filling)
    {
        $this->dough = $dough;
        $this->filling = $filling;
    }

    public function getDough(): string
    {
        return $this->dough;
    }

    public function getFilling(): string
    {
        return $this->filling;
    }

    public function getName(): string
    {
        return get_class($this);
    }

    abstract function wrap(): string;
}
