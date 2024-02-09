<?php

namespace Cases\Php2023\Presentation\Requests;

use Cases\Php2023\Domain\Aggregates\Interface\RequestOrderInterface;

class RequestOrder implements RequestOrderInterface
{
    public string $type;
    public string $quantity;
    public array $addIngredients;
    public array $removeIngredients;

    public function __construct(
        string $type,
        string $quantity,
        array $addIngredients,
        array $removeIngredients
    ) {
        $this->type = $type;
        $this->quantity = $quantity;
        $this->addIngredients = $addIngredients;
        $this->removeIngredients = $removeIngredients;
    }
}