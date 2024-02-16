<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Domain\Entity;

class Book
{
    private int $id;

    public function __construct(
        private string $title,
        private string $sku,
        private string $category,
        private float $price,
        private array $stock,
    ) {}

    public function getId(): int
    {
        return $this->id;
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

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
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

    public function getStock(): array
    {
        return $this->stock;
    }

    public function setStock(array $stock): self
    {
        $this->stock = $stock;
        return $this;
    }
}
