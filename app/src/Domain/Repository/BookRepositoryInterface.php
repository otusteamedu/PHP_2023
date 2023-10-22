<?php

namespace App\Domain\Repository;

interface BookRepositoryInterface
{
    public function searchByTitle(string $title): array;

    public function searchByTitleCategory(string $title, string $category): array;

    public function searchByTitleCategoryPrice(string $title, string $category, string $price): array;

    public function searchByTitleCategoryPriceAvailability(string $title, string $category, string $price): array;
}
