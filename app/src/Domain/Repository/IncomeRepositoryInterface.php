<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Income;

interface IncomeRepositoryInterface
{
    /**
     * @return Income[]
     */
    public function partByDateRange(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo, Pagination $pagination): array;
}
