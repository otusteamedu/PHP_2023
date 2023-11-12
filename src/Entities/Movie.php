<?php

declare(strict_types=1);

namespace App\Entities;

use App\DataMapper\EntityInterface;

final class Movie implements EntityInterface
{
    public function __construct(
        private ?int $id,
        private string $name,
        private ?string $description,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Movie
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Movie
    {
        $this->description = $description;
        return $this;
    }
}
