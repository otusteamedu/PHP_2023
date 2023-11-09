<?php

namespace src\greeting;

use src\Exception\GreetingNullException;
use src\interface\GreetingInterface;

class GreetingNull implements GreetingInterface
{
    /**
     * @throws GreetingNullException
     */
    public function getCaption(string $nick): string
    {
        throw new GreetingNullException('use Greeting without implementation!');
    }
}
