<?php

namespace Shabanov\Otusphp\Decorator;

class OnionIngradient extends AbstractIngradients
{

    public function getInfo(): string
    {
        return parent::getInfo() . ' с луком';
    }
}
