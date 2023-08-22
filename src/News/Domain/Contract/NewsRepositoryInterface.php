<?php

declare(strict_types=1);

namespace App\News\Domain\Contract;

use App\News\Domain\Orm\News;

interface NewsRepositoryInterface
{
    public function create(News $news): void;

    public function getByPage(int $page, int $perPage): array;
}
