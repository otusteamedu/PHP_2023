<?php
declare(strict_types=1);

namespace Builder;

class Director
{
    private $builder;

    public function setBuilder(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function constructProduct()
    {
        $this->builder->buildPart1();
        $this->builder->buildPart2();
    }
}