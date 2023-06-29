<?php
declare(strict_types=1);

namespace Builder;

interface BuilderInterface
{
    public function buildPart1();

    public function buildPart2();

    public function getProduct();
}