<?php

namespace IilyukDmitryi\App\Domain\Order;

use Exception;
use IilyukDmitryi\App\Di;
use IilyukDmitryi\App\Domain\Food\FoodInterface;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\Holiday\DeliveryHolidayStep;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\Holiday\PayHolidayStep;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\Order;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\Workday\CollectStep;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\Workday\CookStep;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\Workday\DeliveryStep;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\Workday\PayStep;

class OrderChainResponsibility implements OrderStrategyInterface
{
    /**
     * @param FoodInterface $food
     * @return void
     * @throws Exception
     */
    public function order(FoodInterface $food): void
    {
        if ($this->isHoliday()) {
            $deliveryStep = Di::getContainer()->get(DeliveryHolidayStep::class);
            $payStep = Di::getContainer()->get(PayHolidayStep::class);
        } else {
            $deliveryStep = Di::getContainer()->get(DeliveryStep::class);
            $payStep = Di::getContainer()->get(PayStep::class);
        }
        $payStep
            ->setNextStep(Di::getContainer()->get(CookStep::class))
            ->setNextStep(Di::getContainer()->get(CollectStep::class))
            ->setNextStep($deliveryStep);

        $order = new Order($food);
        $order->goStep($payStep);
    }

    protected function isHoliday(): bool
    {
        return rand() % 2 == 0;
    }
}
