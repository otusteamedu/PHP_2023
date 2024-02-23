<?php

namespace Shabanov\Otusphp\Entity;

use Shabanov\Otusphp\Interfaces\ObserverInterface;

class Client implements ObserverInterface
{
    public function __construct(private string $name) {}


    public function update($product, $status): void
    {
        echo $this->name . ': Статус приготовления ' . $product->getInfo() . ' -- ' . $status . PHP_EOL;
    }
}
