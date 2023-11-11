<?php

declare(strict_types=1);

namespace User\Php2023\Domain\ObjectValues;

enum FoodType: string {
    case BURGER = 'burger';
    case SANDWICH = 'sandwich';
    case HOTDOG = 'hotdog';

    public function getFoodName(): string {
        return match($this) {
            self::BURGER => 'Бургер',
            self::SANDWICH => 'Сэндвич',
            self::HOTDOG => 'Хот-дог',
        };
    }
}
