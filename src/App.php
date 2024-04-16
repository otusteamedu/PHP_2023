<?php

declare(strict_types=1);

namespace Dmitry\Hw16;

use Dmitry\Hw16\Application\Adapter\PizzaAdapter;
use Dmitry\Hw16\Application\Decorator\OnionDecorator;
use Dmitry\Hw16\Application\Decorator\PepperDecorator;
use Dmitry\Hw16\Application\Decorator\SaladDecorator;
use Dmitry\Hw16\Application\Factory\BurgerFactory;
use Dmitry\Hw16\Application\Factory\ProductFactory;
use Dmitry\Hw16\Application\Publisher\Publisher;
use Dmitry\Hw16\Application\Services\CookingInterface;
use Dmitry\Hw16\Application\Services\CookingService;
use Dmitry\Hw16\Application\UseCase\CookingUseCase;

class App
{
    private CookingInterface $cookingService;

    public function __construct()
    {
        $this->cookingService = new CookingService(new Publisher());
    }

    public function run(): void
    {
        $burger = ProductFactory::makeFood('burger');
        $sandwich = new PepperDecorator(new OnionDecorator(new SaladDecorator(ProductFactory::makeFood('sandwich'))));
        $pizza = new PizzaAdapter();
        $usecase = new CookingUseCase();
        $usecase($this->cookingService, $burger, $sandwich, $pizza);
    }
}
