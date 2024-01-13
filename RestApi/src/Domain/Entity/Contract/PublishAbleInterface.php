<?php

namespace App\Domain\Entity\Contract;

interface PublishAbleInterface
{
    public function getId(): ?int;
    public function getName(): ?string;
    public function setName(string $name): static;
}
