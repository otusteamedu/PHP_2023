<?php
declare(strict_types=1);

namespace Builder;

class ConcreteBuilderInterface implements BuilderInterface
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
