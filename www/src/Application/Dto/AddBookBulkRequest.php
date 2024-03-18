<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application\Dto;

use Yalanskiy\SearchApp\Application\ValueObject\AddBookBulkCollection;

/**
 * AddBookBulkRequest
 */
class AddBookBulkRequest {
    public function __construct(
        public AddBookBulkCollection $books
    )
    {
    }
}