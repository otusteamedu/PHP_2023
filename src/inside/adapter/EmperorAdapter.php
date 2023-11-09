<?php

namespace src\inside\adapter;

use src\inside\typeClass\StringClass;
use src\service\link\EmperorLink;

class EmperorAdapter {
    private bool $isEmperor;

    public function __construct(private readonly StringClass $roleOrName) {
    }

    public function isEmperor(): bool {
        return $this->isEmperor;
    }

    public function detectEmperor(): self {
        $this->isEmperor = EmperorLink::has($this->roleOrName);
        return $this;
    }
}
