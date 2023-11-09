<?php

namespace src\interface;

interface GreetingInterface {
    public function getCaption(string $nick): string;
}
