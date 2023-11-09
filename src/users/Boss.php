<?php

namespace src\users;

use src\interface\NameableUserInterface;

class Boss implements NameableUserInterface {
    const nameDefault = 'boss'; // '1our-boss'

    public function getName(): string {
        return $this::nameDefault;
    }
}
