<?php

declare(strict_types=1);

namespace src\Domain\Entity\Food;

interface FoodInterface
{
    public function getDough(): string;

    public function getFilling(): string;

    public function getName(): string;

    public function wrap(): string;
}
