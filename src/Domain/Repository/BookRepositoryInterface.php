<?php

namespace Dimal\Hw11\Domain\Repository;

use Dimal\Hw11\Domain\Entity\Book;

interface BookRepositoryInterface
{
    public function add(Book $book): void;
    public function getAll(): array;
}