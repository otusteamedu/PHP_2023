<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Expense;
use App\Domain\Repository\ExpenseRepositoryInterface;
use App\Domain\Repository\Pagination;
use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Number;

final class MockExpenseRepository implements ExpenseRepositoryInterface
{
    public function partByDateRange(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo, Pagination $pagination): array
    {
        return [
            new Expense(
                new Id('90'),
                new Money(
                    new Number('20'),
                    new Currency('RUB'),
                ),
                $dateFrom,
            ),
            new Expense(
                new Id('125'),
                new Money(
                    new Number('17.45'),
                    new Currency('RUB'),
                ),
                $dateTo,
            ),
        ];
    }
}
