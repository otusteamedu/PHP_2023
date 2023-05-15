<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\BookRepository;

class BookSearchService {
    private $repository;

    public function __construct() {
        $this->repository = new BookRepository();
    }

    public function search(array $params): array {
        $searchParams = [
            'title' => $params['query'] ?? '',
            'category' => $params['category'] ?? '',
        ];

        if (isset($params['mp'])) {
            $searchParams['price']['lte'] = $params['mp'];
        }

        if (isset($params['minp'])) {
            $searchParams['price']['gte'] = $params['minp'];
        }

        if (isset($params['ms'])) {
            $searchParams['stock']['lte'] = $params['ms'];
        }

        if (isset($params['mins'])) {
            $searchParams['stock']['gte'] = $params['mins'];
        }

        return $this->repository->searchBooks($searchParams);
    }
}
