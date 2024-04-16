<?php

namespace Dmitry\Hw16\Domain\Entity;

class Pizza implements ProductInterface
{
    private string $name;
    private bool $is_cooked = false;

    public function __construct()
    {
        $this->name = 'Пицца';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function makeCooked(): void
    {
        $this->is_cooked = true;
    }
}
