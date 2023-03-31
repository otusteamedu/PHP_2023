<?php

declare(strict_types=1);

namespace Vp\App\DTO;

class SearchParams
{

    public function __construct(
        public readonly ?string $query = null,
        public readonly ?string $category = null,
        public readonly ?string $maxPrice = null
    )
    {
    }
}
