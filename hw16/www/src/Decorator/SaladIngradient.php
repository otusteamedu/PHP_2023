<?php

namespace Shabanov\Otusphp\Decorator;

class SaladIngradient extends AbstractIngradients
{

    public function getInfo(): string
    {
        return parent::getInfo() . ' с салатом';
    }
}
