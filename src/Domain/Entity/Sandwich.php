<?php

namespace Dmitry\Hw16\Domain\Entity;

use Dmitry\Hw16\Domain\Entity\AbstractProduct;

class Sandwich extends Product
{
    public function __construct()
    {
        $this->name = 'Сэндвич';
    }
}
