<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application\Dto;

use Yalanskiy\SearchApp\Domain\Entity\BookCollection;

/**
 * FindBookResponse
 */
class FindBookResponse {
    public function __construct(
        public BookCollection $response,
    )
    {
    
    }
}