<?php

namespace Shabanov\Otusphp\Entity;

use Shabanov\Otusphp\Interfaces\ProductInterface;

class Sandwich implements ProductInterface
{

    public function getInfo(): string
    {
        return 'Сэндвич';
    }
}
