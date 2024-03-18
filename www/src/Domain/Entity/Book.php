<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Domain\Entity;

/**
 * Book
 */
class Book {
    
    private string $id;
    private string $score;
    
    public function __construct(
        private string $sku,
        private string $title,
        private string $category,
        private float $price,
        private array $stock,
    ) {
    }
    
    public function getSku(): string
    {
        return $this->sku;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getCategory(): string
    {
        return $this->category;
    }
    
    public function getPrice(): float
    {
        return $this->price;
    }
    
    public function getStock(): array
    {
        return $this->stock;
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function setId(string $id): void
    {
        $this->id = $id;
    }
    
    public function getScore(): string
    {
        return $this->score;
    }
    
    public function setScore(string $score): void
    {
        $this->score = $score;
    }
    
}