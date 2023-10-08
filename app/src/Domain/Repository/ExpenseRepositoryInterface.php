<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Expense;

interface ExpenseRepositoryInterface
{
    /**
     * @return Expense[]
     */
    public function partByDateRange(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo, Pagination $pagination): array;
}
