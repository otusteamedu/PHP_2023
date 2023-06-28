<?php
declare(strict_types=1);


class Product
{
    private $part1;
    private $part2;

    public function setPart1($part1)
    {
        $this->part1 = $part1;
    }

    public function setPart2($part2)
    {
        $this->part2 = $part2;
    }

    public function getParts()
    {
        return "Part 1: " . $this->part1 . ", Part 2: " . $this->part2;
    }
}

interface Builder
{
    public function buildPart1();

    public function buildPart2();

    public function getProduct();
}

class ConcreteBuilder implements Builder
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function buildPart1()
    {
        $this->product->setPart1("Part 1");
    }

    public function buildPart2()
    {
        $this->product->setPart2("Part 2");
    }

    public function getProduct()
    {
        return $this->product;
    }
}

class Director
{
    private $builder;

    public function setBuilder(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function constructProduct()
    {
        $this->builder->buildPart1();
        $this->builder->buildPart2();
    }
}

$builder = new ConcreteBuilder();
$director = new Director();

$director->setBuilder($builder);
$director->constructProduct();

$product = $builder->getProduct();
echo $product->getParts();


