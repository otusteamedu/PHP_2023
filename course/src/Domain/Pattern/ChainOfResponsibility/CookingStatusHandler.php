<?php

namespace Cases\Php2023\Domain\Pattern\ChainOfResponsibility;

use Cases\Php2023\Domain\Aggregates\Abstract\AbstractHandler;

class CookingStatusHandler extends AbstractHandler
{
    public function handle(): ?string
    {
        echo "Уведомление: блюдо находится в процессе приготовления.\n";
        return parent::handle();
    }
}