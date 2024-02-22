<?php

namespace Dimal\Hw11\Domain\Repository;

use Dimal\Hw11\Application\SearchQueryDTO;
use Dimal\Hw11\Domain\Entity\Book;

interface BookRepositoryInterface
{
    public function add(Book $book): void;

    public function getAll(): array;

    public function search(SearchQueryDTO $searchQuery): array;
}
