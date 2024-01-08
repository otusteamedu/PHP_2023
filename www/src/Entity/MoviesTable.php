<?php

declare(strict_types=1);

namespace Chernomordov\App\Entity;

class MoviesTable
{
    public function __construct(
        private int $id,
        private ?string $name,
        private ?string $duration,
        private ?string $productionYear
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): void
    {
        $this->duration = $duration;
    }

    public function getProductionYear(): ?string
    {
        return $this->productionYear;
    }

    public function setProductionYear(?string $productionYear): void
    {
        $this->productionYear = $productionYear;
    }
}
