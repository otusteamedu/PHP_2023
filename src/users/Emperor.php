<?php

namespace src\users;

use src\interface\NameableUserInterface;

class Emperor implements NameableUserInterface {
    function __construct(private readonly string $name) {
    }

    public function getName(): string {
        return $this->name;
    }
}
