<?php

namespace Shabanov\Otusphp\DataMapper;

class Product
{
    private int $id;
    private string $title;
    private ?string $description;
    private ?string $color;
    private ?string $volume;
    private float $price;

    public function __construct(int $id, string $title, ?string $description, ?string $color, ?string $volume, float $price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->color = $color;
        $this->volume = $volume;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(?string $volume): self
    {
        $this->volume = $volume;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }
}
