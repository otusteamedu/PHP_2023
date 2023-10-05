<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\PaginatedList;

use App\Domain\Repository\Pagination;

final class GetPaginatedListNewsResult
{
    public function __construct(
        public readonly array $news,
        public readonly Pagination $pagination,
    ) {
    }
}
