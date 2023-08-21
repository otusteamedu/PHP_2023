<?php

declare(strict_types=1);

namespace MaximBazlov\Hw3;

use MaximBazlov\OtusComposerPackage\Calculator;

class TestCalculator
{
    public function test(): void
    {
        $calculator = new Calculator();

        echo $calculator->sum(1, 3);
    }
}
