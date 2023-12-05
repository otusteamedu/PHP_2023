<?php

declare(strict_types=1);

namespace App\Entity\Builder;

use App\Entity\Contract;

class ContractBuilder
{
    private ?string $header = null;
    private ?string $preamble = null;
    private ?string $text = null;
    private ?string $signature = null;

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(?string $header): ContractBuilder
    {
        $this->header = $header;

        return $this;
    }

    public function getPreamble(): ?string
    {
        return $this->preamble;
    }

    public function setPreamble(?string $preamble): ContractBuilder
    {
        $this->preamble = $preamble;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): ContractBuilder
    {
        $this->text = $text;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): ContractBuilder
    {
        $this->signature = $signature;

        return $this;
    }

    public function build(): Contract
    {
        return new Contract($this);
    }
}
