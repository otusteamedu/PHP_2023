<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Name;

class Status
{
    private Name $name;

    private ?int $id = null;

    public function __construct(Name $name)
    {
        $this->name = $name;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
