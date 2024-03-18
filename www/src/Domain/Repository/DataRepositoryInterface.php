<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Domain\Repository;

use Yalanskiy\SearchApp\Domain\Entity\Book;
use Yalanskiy\SearchApp\Domain\Entity\BookCollection;

/**
 * DataRepositoryInterface
 */
interface DataRepositoryInterface
{
    public function find(array $searchParams): BookCollection;
    
    public function add(Book $data): void;
    
    public function addBulk(BookCollection $data): void;
}