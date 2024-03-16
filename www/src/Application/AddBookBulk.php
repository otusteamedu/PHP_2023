<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application;

use Yalanskiy\SearchApp\Application\Dto\AddBookBulkRequest;
use Yalanskiy\SearchApp\Domain\Entity\Book;
use Yalanskiy\SearchApp\Domain\Entity\BookCollection;
use Yalanskiy\SearchApp\Domain\Repository\DataRepositoryInterface;

/**
 * AddBookBulk
 */
class AddBookBulk {
    public function __construct(
        private DataRepositoryInterface $provider
    )
    {
    
    }
    
    public function __invoke(AddBookBulkRequest $request): void
    {
        $data = new BookCollection();
        foreach ($request->books as $item) {
            $book = new Book(
                $item->sku,
                $item->title,
                $item->category,
                $item->price,
                $item->stock
            );
            if (!empty($item->id)) {
                $book->setId($item->id);
            }
            
            $data->add($book);
        }
        
        $this->provider->addBulk($data);
    }
}