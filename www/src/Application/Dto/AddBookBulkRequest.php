<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application\Dto;

/**
 * AddBookBulkRequest
 */
class AddBookBulkRequest {
    
    public array $books = [];
    
    public function __construct(array $books)
    {
        foreach ($books as $book) {
            $this->books[] = new AddBookRequest(
                $book['sku'],
                $book['title'],
                $book['category'],
                $book['price'],
                $book['stock'],
                $book['id'] ?? ''
            );
        }
    }
}