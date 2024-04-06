<?php


namespace App\Service;

use App\Entity\Book;

class SearchService
{
    private ElasticsearchService $elasticsearchService;

    public function __construct(ElasticsearchService $elasticsearchService)
    {
        $this->elasticsearchService = $elasticsearchService;
    }

    public function searchBooks(string $title = null, string $category = null, int $minPrice = null, int $maxPrice = null): array
    {
        // Формируем запрос в Elasticsearch
        // Возвращаем результаты поиска
    }
}
