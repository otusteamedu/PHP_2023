<?php

declare(strict_types=1);

namespace AYamaliev\Hw16;

use AYamaliev\Hw16\Application\Decorator\OnionDecorator;
use AYamaliev\Hw16\Application\Decorator\PepperDecorator;
use AYamaliev\Hw16\Application\Decorator\SaladDecorator;
use AYamaliev\Hw16\Application\ProductFactory\BurgerFactory;
use AYamaliev\Hw16\Application\Proxy\ProductProxy;
use AYamaliev\Hw16\Application\Strategy\CookBurger;
use AYamaliev\Hw16\Domain\Observer\PublisherInterface;

class App
{
    public function __construct(
        private PublisherInterface $publisher,
    )
    {
    }

    public function __invoke(): void
    {
        $productFactory = new BurgerFactory();
        $burger = $productFactory->cook('биг-мак', 150.00);

        $burger = new PepperDecorator(
            new OnionDecorator(
                new SaladDecorator(
                    $burger,
                    15.00
                ),
                25.00
            ),
            7.00
        );

        $burgerProxy = new ProductProxy($burger);

        (new CookBurger())->cook($burgerProxy);

        $this->publisher->notify($burgerProxy);
    }
}