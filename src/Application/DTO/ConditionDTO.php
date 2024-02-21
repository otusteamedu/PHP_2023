<?php
declare(strict_types=1);

namespace App\Application\DTO;

class ConditionDTO
{
    public function __construct(
        private ?string $operandLeft,
        private ?string $operandRight,
    ) {
    }

    public function getOperandLeft(): ?string
    {
        return $this->operandLeft;
    }

    public function setOperandLeft(?string $operandLeft): self
    {
        $this->operandLeft = $operandLeft;

        return $this;
    }

    public function getOperandRight(): ?string
    {
        return $this->operandRight;
    }

    public function setOperandRight(?string $operandRight): self
    {
        $this->operandRight = $operandRight;

        return $this;
    }
}
