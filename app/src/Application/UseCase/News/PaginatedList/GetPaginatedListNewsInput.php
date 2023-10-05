<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\PaginatedList;

interface GetPaginatedListNewsInput
{
    public function getPage(): int;

    public function getPerPage(): int;
}
