<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application\Dto;

/**
 * AddBookRequest
 */
class AddBookRequest {
    public function __construct(
        public string $sku,
        public string $title,
        public string $category,
        public float $price,
        public array $stock,
        public string $id
    )
    {
    
    }
}