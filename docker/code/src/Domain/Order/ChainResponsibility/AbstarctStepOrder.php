<?php

namespace IilyukDmitryi\App\Domain\Order\ChainResponsibility;

use IilyukDmitryi\App\Domain\Food\FoodInterface;

class AbstarctStepOrder implements StepOrderInterface
{

    public function __construct(protected ?StepOrderInterface $nextStepOrder = null)
    {
    }

    public function setNextStep(StepOrderInterface $nextStepOrder): StepOrderInterface
    {
        $this->nextStepOrder = $nextStepOrder;
        return $nextStepOrder;
    }

    public function step(FoodInterface $food): void
    {
        if (!is_null($this->nextStepOrder)) {
            $this->nextStepOrder->step($food);
        }
    }
}
