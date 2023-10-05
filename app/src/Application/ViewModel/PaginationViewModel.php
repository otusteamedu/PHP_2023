<?php

namespace App\Application\ViewModel;

class PaginationViewModel
{
    public function __construct(
        public readonly int $page,
        public readonly int $perPage,
        public readonly ?int $count,
        public readonly ?int $countPages,
    ) {
    }
}
