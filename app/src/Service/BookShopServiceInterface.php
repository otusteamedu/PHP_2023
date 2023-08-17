<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\BookSearchDto;

interface BookShopServiceInterface
{
    public function search(BookSearchDto $searchDto): SearchResult;

    /**
     * @return string[]
     */
    public function getAvailableCategories(): array;

    /**
     * @return string[]
     */
    public function getAvailableShops(): array;
}