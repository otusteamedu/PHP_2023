<?php

namespace Cases\Php2023\Domain\Pattern\ChainOfResponsibility;

use Cases\Php2023\Domain\Aggregates\Abstract\AbstractHandler;

class CookingCompleteHandler extends AbstractHandler
{
    public function handle(): ?string
    {
        echo "Уведомление: блюдо приготовлено.\n";
        return parent::handle();
    }
}
