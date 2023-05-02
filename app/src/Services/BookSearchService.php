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
            'query' => $params['query'],
            'category' => $params['category'],
            'max_price' => $params['max_price'],
        ];

        return $this->repository->searchBooks($searchParams);
    }
}
