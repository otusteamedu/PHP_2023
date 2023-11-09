<?php

namespace src\inside\typeClass;

interface CustomizableInterface
{
    public function customize($value): self;
    public function from($value): self;
}
