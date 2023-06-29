<?php
declare(strict_types=1);

use Strategy\StrategyInterface;

class Context
{
    private $strategy;

    public function setStrategy(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executeStrategy($num1, $num2)
    {
        return $this->strategy->doOperation($num1, $num2);
    }
}
