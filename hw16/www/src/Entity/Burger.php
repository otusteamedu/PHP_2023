<?php

namespace Shabanov\Otusphp\Entity;

use Shabanov\Otusphp\Interfaces\ProductInterface;

class Burger implements ProductInterface
{

    public function getInfo(): string
    {
        return 'Бургер';
    }
}
