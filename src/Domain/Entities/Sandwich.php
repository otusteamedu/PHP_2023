<?php

declare(strict_types=1);

namespace User\Php2023\Domain\Entities;

use User\Php2023\Domain\ObjectValues\FoodType;

class Sandwich extends FoodItem
{
    public function __construct()
    {
        parent::__construct(FoodType::SANDWICH);
    }
}
