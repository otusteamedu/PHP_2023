<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application\Dto;

/**
 * FindBookRequest
 */
class FindBookRequest {
    public function __construct(
        public array $params,
    )
    {
    
    }
}