<?php

namespace Dmitry\Hw16\Domain\Entity;

use Dmitry\Hw16\Domain\Entity\AbstractProduct;

class Hotdog extends Product
{
    public function __construct()
    {
        $this->name = 'Хотдог';
    }
}
