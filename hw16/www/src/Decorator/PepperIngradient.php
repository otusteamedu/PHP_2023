<?php

namespace Shabanov\Otusphp\Decorator;

class PepperIngradient extends AbstractIngradients
{
    public function getInfo(): string
    {
        return parent::getInfo() . ' с перцем';
    }
}
