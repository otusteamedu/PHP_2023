<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application;

use Yalanskiy\SearchApp\Application\Dto\AddBookRequest;
use Yalanskiy\SearchApp\Domain\Entity\Book;
use Yalanskiy\SearchApp\Domain\Repository\DataRepositoryInterface;

/**
 * AddBook
 */
class AddBook {
    public function __construct(
        private DataRepositoryInterface $provider
    )
    {
    
    }
    
    public function __invoke(AddBookRequest $request): void
    {
        $book = new Book(
            $request->sku,
            $request->title,
            $request->category,
            $request->price,
            $request->stock
        );
        if (!empty($request->id)) {
            $book->setId($request->id);
        }
        
        $this->provider->add($book);
    }
}