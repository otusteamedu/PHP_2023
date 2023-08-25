<?php

namespace IilyukDmitryi\App\Application\UseCase;

use IilyukDmitryi\App\Application\Dto\CreateFoodResponse;
use IilyukDmitryi\App\Di;
use IilyukDmitryi\App\Domain\CreatorFood\CreatorBurger;
use IilyukDmitryi\App\Domain\Order\Order;

class CreateBurgerUseCase
{
    public static function exec(): CreateFoodResponse
    {
        try {
            $creatorFood = Di::getContainer()->get(CreatorBurger::class);
            $order = new Order($creatorFood);
            $order->exec();
            $foodName = $order->getFood()->getFormatName();
            $createFoodResponse = new  CreateFoodResponse(
                "Заказ выполнен, ваш " . $foodName . " готов!",
                false,
                $foodName
            );
        } catch (\Throwable $th) {
            $createFoodResponse = new  CreateFoodResponse("Заказ не выполнен. " . $th->getMessage(), true);
        }
        return $createFoodResponse;
    }
}
