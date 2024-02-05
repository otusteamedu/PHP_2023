<?php

namespace Dimal\Hw11\Infrastructure;

use Dimal\Hw11\Domain\Entity\Book;
use Dimal\Hw11\Domain\Repository\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    private array $books = [];

    public function add(Book $book): void
    {
        $this->books[] = $book;
    }

    public function getAll(): array
    {
        return $this->books;
    }
}
