<?php

namespace App\Domain\Builder;

use App\Domain\Dto\AuthorDto;
use App\Domain\Dto\CategoryDto;
use DateTimeInterface;

interface BuilderInterface
{
    public function reset(): void;

    public function setName(string $name): void;

    public function setCreationDate(DateTimeInterface $creationDate): void;

    public function setAuthor(AuthorDto $authorDto): void;

    public function setCategory(CategoryDto $categoryDto): void;
}
