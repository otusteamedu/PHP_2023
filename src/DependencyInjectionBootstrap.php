<?php

declare(strict_types=1);

namespace User\Php2023;

use User\Php2023\Application\Services\CookingProcess;
use User\Php2023\Application\Services\OrderBuilder;
use User\Php2023\Infrastructure\Cooking\CookingProxy;
use User\Php2023\Infrastructure\Food\FoodFactory;
use User\Php2023\Infrastructure\Order\Order;

class DependencyInjectionBootstrap
{
    public static function setUp(DIContainer $container): void
    {
        $container->set(FoodFactory::class, function () {
            return new FoodFactory();
        });

        $container->set(Order::class, function () {
            return new Order();
        });

        $container->set(OrderBuilder::class, function () {
            return new OrderBuilder();
        });


        $container->set(CookingProcess::class, function () {
            return CookingProcess::getInstance();
        });

        $container->set(CookingProxy::class, function () {
            return new CookingProxy();
        });

        $container->set(App::class, function ($container) {
            return new App(
                $container->get(FoodFactory::class),
                $container->get(OrderBuilder::class),
                $container->get(CookingProcess::class),
                $container->get(CookingProxy::class),
            );
        });
    }
}
