<?php

namespace IilyukDmitryi\App\Domain\Food;

interface FoodInterface
{
    public function getIngredients(): array;

    public function getNameFood(): string;

    public function setIngredients(array $arrIngredients): self;

    public function setNameFood(string $name): self;

    public function setPrice(int $price): self;

    public function getPrice(): int;

    public function getFormatName(): string;
}
