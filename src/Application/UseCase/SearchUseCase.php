<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;
use src\Application\Repositories\BookRepositoryContract;

class SearchUseCase
{
    public function __construct(private BookRepositoryContract $bookRepository)
    {}

    public function __invoke(string $title, string $category, string $price): Elasticsearch|Promise
    {
        return $this->bookRepository->search($title, $category, $price);
    }
}
