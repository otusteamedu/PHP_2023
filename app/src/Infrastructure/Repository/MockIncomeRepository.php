<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Income;
use App\Domain\Repository\IncomeRepositoryInterface;
use App\Domain\Repository\Pagination;
use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Number;

final class MockIncomeRepository implements IncomeRepositoryInterface
{
    public function partByDateRange(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo, Pagination $pagination): array
    {
        return [
            new Income(
                new Id('101'),
                new Money(
                    new Number('94.25'),
                    new Currency('RUB'),
                ),
                $dateFrom,
            ),
            new Income(
                new Id('102'),
                new Money(
                    new Number('41.37'),
                    new Currency('RUB'),
                ),
                $dateTo,
            ),
        ];
    }
}
