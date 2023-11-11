<?php

declare(strict_types=1);

namespace User\Php2023\Application\Observers;

use User\Php2023\Domain\Interfaces\Food;
use User\Php2023\Domain\Interfaces\Observer;
use User\Php2023\Domain\ObjectValues\PrepareStatus;

class MobileAppObserver implements Observer
{
    public function update(Food $food, int $status): void
    {
        $statusName = PrepareStatus::from($status)->getStatusName();
        echo "[" . $food->type->getFoodName() . "] #" . $food->number . " - Статус приготовления: $statusName\n";
    }
}
