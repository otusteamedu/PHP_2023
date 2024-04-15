<?php

namespace Dmitry\Hw16\Domain\Entity;

interface ProductInterface
{
    public function getName(): string;

    public function makeCooked(): void;
}
