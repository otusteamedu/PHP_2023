<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\PaginatedList;

use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Repository\Pagination;

final class GetPaginatedListNews
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function handle(GetPaginatedListNewsInput $input): GetPaginatedListNewsResult
    {
        $count = $this->newsRepository->countAll();
        $pagination = new Pagination($input->getPage(), $input->getPerPage(), $count);
        $news = $this->newsRepository->part($pagination);

        return new GetPaginatedListNewsResult($news, $pagination);
    }
}
