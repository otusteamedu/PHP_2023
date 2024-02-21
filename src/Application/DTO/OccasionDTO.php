<?php
declare(strict_types=1);

namespace App\Application\DTO;

class OccasionDTO
{
    public function __construct(
        private ?string $name,
        private ?string $value,
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
