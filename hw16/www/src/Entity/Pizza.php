<?php

namespace Shabanov\Otusphp\Entity;

use Shabanov\Otusphp\Interfaces\ProductInterface;

class Pizza implements ProductInterface
{
    public function getInfo(): string
    {
        return 'Пицца';
    }
}
