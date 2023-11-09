<?php

namespace src\users;

use src\interface\NameableUserInterface;

class Manager implements NameableUserInterface {
    const nameDefault = 'manager';

    public function getName(): string {
        return $this::nameDefault;
    }
}
