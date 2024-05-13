<?php

namespace AYamaliev\Hw16\Domain\Entity;

interface ProductInterface
{
    public function getTitle(): string;

    public function getPrice(): float;

    public function cook(): void;
}