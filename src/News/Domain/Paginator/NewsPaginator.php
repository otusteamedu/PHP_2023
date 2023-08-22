<?php

declare(strict_types=1);

namespace App\News\Domain\Paginator;

use App\News\Domain\Contract\NewsRepositoryInterface;

final readonly class NewsPaginator
{
    public function __construct(
        private NewsRepositoryInterface $repository,
        private int $perPage = 2,
    ) {
    }

    public function paginate(int $page = 1): NewsCollection
    {
        $news = $this->repository->getByPage($page, $this->perPage);

        return new NewsCollection($news);
    }
}