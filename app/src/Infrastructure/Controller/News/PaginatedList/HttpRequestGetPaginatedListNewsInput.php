<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\News\PaginatedList;

use App\Application\UseCase\News\PaginatedList\GetPaginatedListNewsInput;
use App\Infrastructure\Request\HttpRequest;

final class HttpRequestGetPaginatedListNewsInput extends HttpRequest implements GetPaginatedListNewsInput
{
    public function getPage(): int
    {
        return (int) $this->getRequest()->get('page', 1);
    }

    public function getPerPage(): int
    {
        return (int) $this->getRequest()->get('perPage', 20);
    }
}
