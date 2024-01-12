<?php

namespace App\Domain\Entity\Contract;

interface DecoratorInterface
{
    public function getText(): ?string;
    public function setText(string $text): static;
}
