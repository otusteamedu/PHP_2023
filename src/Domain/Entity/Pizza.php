<?php

namespace Dmitry\Hw16\Domain\Entity;

class Pizza extends Product
{
    public function __construct()
    {
        $this->name = 'Пицца';
    }
}
