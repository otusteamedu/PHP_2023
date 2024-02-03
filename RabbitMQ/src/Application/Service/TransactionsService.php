<?php

namespace App\Application\Service;

use App\Application\Contracts\ExpenseRepositoryInterface;
use App\Application\Contracts\IncomeRepositoryInterface;
use App\Application\Dto\DateIntervalDto;

readonly class TransactionsService
{
    public function __construct(
        private ExpenseRepositoryInterface $expensiveRepository,
        private IncomeRepositoryInterface  $incomeRepository
    ) {
    }

    public function getTransactionsInfo(DateIntervalDto $dateIntervalDto): string
    {
        $transactionsInfo = '';

        $incomes = $this->incomeRepository->findByBetweenDates(
            $dateIntervalDto->getDateFrom(),
            $dateIntervalDto->getDateTo()
        );

        foreach ($incomes as $income) {
            $transactionsInfo .= sprintf(
                    '%s: +%s %s',
                    $income->getDate()->format('d.m.Y H:i:s'),
                    $income->getAmount(),
                    $income->getCurrency(),
                ) . PHP_EOL;
        }

        $expenses = $this->expensiveRepository->findByBetweenDates(
            $dateIntervalDto->getDateFrom(),
            $dateIntervalDto->getDateTo()
        );

        foreach ($expenses as $expense) {
            $transactionsInfo .= sprintf(
                    '%s: %s %s',
                    $expense->getDate()->format('d.m.Y H:i:s'),
                    $expense->getAmount(),
                    $expense->getCurrency(),
                ) . PHP_EOL;
        }

        return $transactionsInfo;
    }
}
