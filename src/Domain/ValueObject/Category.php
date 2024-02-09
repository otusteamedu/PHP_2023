<?php

namespace Dimal\Hw11\Domain\ValueObject;

class Category
{
    private ?string $name;

    public function __construct(string $name = null)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
