<?php

use IilyukDmitryi\App\Domain\Order\OrderChainResponsibility;
use IilyukDmitryi\App\Domain\Order\OrderStrategyInterface;
use IilyukDmitryi\App\Domain\Order\OrderTemplateMethod;

return [
    OrderStrategyInterface::class => DI\create(OrderChainResponsibility::class),
    //OrderStrategyInterface::class => DI\create(OrderTemplateMethod::class),
];


