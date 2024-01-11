<?php

namespace App\Application\Builder;

use DateTimeInterface;

interface BuilderInterface
{
    public function reset(): void;

    public function setName(string $name): void;

    public function setCreationDate(DateTimeInterface $creationDate): void;

    public function setAuthor(int $authorId): void;

    /**
     * @param int[] $categoriesId
     */
    public function setCategories(array $categoriesId): void;

    public function setText(string $text): void;
}
