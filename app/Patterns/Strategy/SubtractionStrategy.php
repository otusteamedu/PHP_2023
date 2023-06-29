<?php
declare(strict_types=1);

namespace Strategy;

use Strategy;

class SubtractionStrategy implements StrategyInterface
{
    public function doOperation($num1, $num2)
    {
        return $num1 - $num2;
    }
}
