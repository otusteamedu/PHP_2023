<?php

declare(strict_types=1);

namespace App\ChainOfResponsibility;

use App\Builder\FoodInterface;

abstract class FoodHandler
{
    public function __construct(private ?FoodHandler $foodHandler = null)
    {
    }

    public function setNext(FoodHandler $foodHandler): FoodHandler
    {
        $this->foodHandler = $foodHandler;
        return $foodHandler;
    }

    public function handle(FoodInterface $food): void
    {
        $this->foodHandler?->handle($food);
    }
}
