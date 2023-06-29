<?php
declare(strict_types=1);


use Builder\ConcreteBuilderInterface;
use Builder\Director;

$builder = new ConcreteBuilderInterface();
$director = new Director();

$director->setBuilder($builder);
$director->constructProduct();

$product = $builder->getProduct();
echo $product->getParts();


