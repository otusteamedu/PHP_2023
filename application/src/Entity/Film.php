<?php

declare(strict_types=1);

namespace Gesparo\HW\Entity;

use Gesparo\HW\ModelRelation;

class Film extends BaseEntity
{
    private string $name;
    private int $duration;
    private string $description;
    private string $actors;
    private string $country;
    private string $createdAt;
    private string $updatedAt;

    private ModelRelation $screenings;

    public function __construct(
        int $id,
        string $name,
        int $duration,
        string $description,
        string $actors,
        string $country,
        string $createdAt,
        string $updatedAt,
        ModelRelation $screenings
    ) {
        parent::__construct($id);

        $this->name = $name;
        $this->duration = $duration;
        $this->description = $description;
        $this->actors = $actors;
        $this->country = $country;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->screenings = $screenings;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Film
    {
        $this->name = $name;
        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): Film
    {
        $this->duration = $duration;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Film
    {
        $this->description = $description;
        return $this;
    }

    public function getActors(): string
    {
        return $this->actors;
    }

    public function setActors(string $actors): Film
    {
        $this->actors = $actors;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): Film
    {
        $this->country = $country;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): Film
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): Film
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getScreenings(): ModelRelation
    {
        return $this->screenings;
    }
}
