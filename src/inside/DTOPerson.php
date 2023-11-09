<?php

namespace src\inside;

use src\inside\typeClass\StringClass;

class DTOPerson {
    private StringClass $role;
    private StringClass $name;
    private StringClass $key;

    private function __construct() {
        $this->setName(StringClass::build()->from(''));
    }

    public static function build(): self {
        return new self();
    }

    public function getRole(): StringClass {
        return $this->role;
    }

    public function setRole(StringClass $role): self {
        $this->role = $role;
        return $this;
    }

    public function getName(): StringClass {
        return $this->name;
    }

    public function setName(StringClass $name): self {
        $this->name = $name;
        return $this;
    }

    public function getKey(): StringClass {
        return $this->key;
    }

    public function setKey(StringClass $key): self {
        $this->key = $key;
        return $this;
    }
}
