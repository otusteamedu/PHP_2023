<?php

namespace src\greeting;

use src\interface\GreetingInterface;

class GreetingEmperor implements GreetingInterface
{
    private const CAPTION = 'Ave, Csr';

    public function getCaption(string $nick): string
    {
        return $this::CAPTION;
    }
}
