<?php

namespace App\Infrastructure\Repository;

interface RepositoryQueryInterface
{
    public function searchByTitle(string $title): array;

    public function searchByTitleCategoryPrice(string $title, string $category, string $price): array;
}
