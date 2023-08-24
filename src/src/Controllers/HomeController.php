<?php

namespace App\Controllers;

use App\Models\AbstractFactory\ProductFactory;
use App\Models\Decorators\SaladDecorator;
use App\Models\Decorators\OnionDecorator;
use App\Models\Decorators\PepperDecorator;
use App\Models\CookingStatus;
use App\Views\ProductView;

class HomeController
{
    public function index()
    {
        $productFactory = new ProductFactory();

        $burger = $productFactory->createBurger();
        $sandwich = $productFactory->createSandwich();
        $hotDog = $productFactory->createHotDog();

        $burgerWithSalad = new SaladDecorator($burger);
        $sandwichWithOnion = new OnionDecorator($sandwich);
        $hotDogWithPepper = new PepperDecorator($hotDog);

        $cookingStatus = new CookingStatus();
        $burgerWithSalad->addObserver($cookingStatus);
        $sandwichWithOnion->addObserver($cookingStatus);
        $hotDogWithPepper->addObserver($cookingStatus);

        $cookingStatus = new CookingStatus();
        $burgerProxy = new CookingProxy($burgerWithSalad, $cookingStatus);
        $sandwichProxy = new CookingProxy($sandwichWithOnion, $cookingStatus);
        $hotDogProxy = new CookingProxy($hotDogWithPepper, $cookingStatus);

        $productView = new ProductView();
        $productView->display([$burgerProxy, $sandwichProxy, $hotDogProxy]);
    }
}
