<?php

namespace src\users;

use src\interface\NameableUserInterface;

class Guest implements NameableUserInterface {
    const nameDefault = 'guest';

    public function getName(): string {
        return $this::nameDefault;
    }
}
