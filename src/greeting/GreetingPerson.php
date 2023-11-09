<?php

namespace src\greeting;

use src\interface\GreetingInterface;

class GreetingPerson implements GreetingInterface {
    private const GREETING_FORMAT = "Hello, %s!";

    public function getCaption(string $nick): string {
        return sprintf($this::GREETING_FORMAT, $nick);
    }
}
