<?php

declare(strict_types=1);

use Root\App\Burger\BurgerFactory;
use Root\App\Burger\BurgerStandartBuilder;
use Root\App\Burger\BurgerWithPepperBuilder;
use Root\App\HotDog\HotDogBuilder;
use Root\App\RestaurantFastFood;
use Root\App\Sandwich\SandwichFactory;

require __DIR__ . '/vendor/autoload.php';

$restaurant = new RestaurantFastFood();

$burgerFactory = new BurgerFactory();
$sandwichFactory = new SandwichFactory();

$burgerBuilderStandart = new BurgerStandartBuilder();
$burgerBuilderPepper = new BurgerWithPepperBuilder();

$burger1 = $burgerFactory->createBuilder()->build();
$burger2 = $burgerFactory->createBuilder()->addPepper(3)->addOnion(4)->build();

$sandwich1 = $sandwichFactory->createBuilder()->build();
$sandwich2 = $sandwichFactory->createBuilder()->addPepper(10)->build();


$restaurant->execute($burger1, $burgerFactory->createCookingStrategy());
$restaurant->execute($burger2, $burgerFactory->createCookingStrategy());

$restaurant->execute($sandwich1, $sandwichFactory->createCookingStrategy());
$restaurant->execute($sandwich2, $sandwichFactory->createCookingStrategy());


$hotDog = (new HotDogBuilder())->build();
$restaurant->execute($hotDog, $burgerFactory->createCookingStrategy());
