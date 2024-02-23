<?php

namespace Shabanov\Otusphp\Entity;

use Shabanov\Otusphp\Interfaces\ProductInterface;

class HotDog implements ProductInterface
{

    public function getInfo(): string
    {
        return 'Хот дог';
    }
}
