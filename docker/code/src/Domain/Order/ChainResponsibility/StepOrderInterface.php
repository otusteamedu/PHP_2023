<?php

namespace IilyukDmitryi\App\Domain\Order\ChainResponsibility;

use IilyukDmitryi\App\Domain\Food\FoodInterface;

interface StepOrderInterface
{
    public function setNextStep(StepOrderInterface $nextStepOrder): StepOrderInterface;

    public function step(FoodInterface $food): void;
}
