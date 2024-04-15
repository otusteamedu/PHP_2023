<?php

namespace Dmitry\Hw16\Domain\Entity;

abstract class Product implements ProductInterface
{
    protected $name;
    private $is_cooked = false;

    abstract public function __construct();

    public function getName(): string
    {
        return $this->name;
    }

    public function makeCooked(): void
    {
        $this->is_cooked = true;
    }
}
