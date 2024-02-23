<?php

namespace Shabanov\Otusphp\Interfaces;

interface ObserverInterface
{
    public function update(ProductInterface $product, string $status);
}
