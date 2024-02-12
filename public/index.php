<?php

declare(strict_types=1);

use App\Builder\FoodBuilder;
use App\ChainOfResponsibility\CutVegetableHandler;
use App\ChainOfResponsibility\FoodMiddleware;
use App\ChainOfResponsibility\RoastMeatHandler;
use App\Decorator\MushroomsDecorator;
use App\Observer\CookingStatusPublisher;
use App\Observer\User;
use App\Proxy\FoodProxy;

define("APP_PATH", dirname(__DIR__));

require_once APP_PATH . "/vendor/autoload.php";

// Строитель
$pizza = (new FoodBuilder())
    ->setName('Pizza')
    ->setDescription('Super Pizza')
    ->setPrice(100)
    ->setIngredients(['tomato', 'pepper', 'onion'])
    ->build();

dump($pizza);

// Декоратор
$pizzaWithMushrooms = new MushroomsDecorator($pizza);

dump($pizzaWithMushrooms->getIngredients());

// Наблюдатель
$cookingStatusPublisher = new CookingStatusPublisher($pizza);

$vasya = new User('Вася');
$petya = new User('Петя');

$cookingStatusPublisher->subscribe($vasya); // Вася подписался на статус приготовления своего заказа
$cookingStatusPublisher->subscribe($petya); // и Петя подписался на статус приготовления заказа своего друга

$cookingStatusPublisher->setStatus('cooking');
$cookingStatusPublisher->setStatus('ready');

// Прокси
$burger = (new FoodBuilder())
    ->setName('Burger')
    ->setDescription('Super Burger')
    ->setPrice(100)
    ->setIngredients([])
    ->build();

$proxyBurger = new FoodProxy($burger);

dump($proxyBurger->toCook());

$sandwich = (new FoodBuilder())
    ->setName('Sandwich')
    ->setDescription('Super Sandwich')
    ->setPrice(100)
    ->setIngredients(['meat'])
    ->build();

$proxySandwich = new FoodProxy($sandwich);

dump($proxySandwich->toCook());

// Цепочка обязанностей
$handler = new CutVegetableHandler();
$handler->setNext(new RoastMeatHandler());

$middleware = new FoodMiddleware($handler);
$middleware->do($pizza);
