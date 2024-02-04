<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Contracts\ExpenseRepositoryInterface;
use App\Application\Contracts\IncomeRepositoryInterface;
use App\Application\Dto\TransactionsInfoDto;
use App\Application\Service\Exception\GetTransactionsDataException;
use Exception;

readonly class TransactionsService
{
    public function __construct(
        private ExpenseRepositoryInterface $expensiveRepository,
        private IncomeRepositoryInterface  $incomeRepository
    ) {
    }

    /**
     * @throws GetTransactionsDataException
     */
    public function getTransactionsInfo(TransactionsInfoDto $transactionsInfoDto): string
    {
        $transactionsByPeriod = '';

        try {
            $incomes = $this->incomeRepository->findByBetweenDates(
                $transactionsInfoDto->getDateFrom(),
                $transactionsInfoDto->getDateTo()
            );

            foreach ($incomes as $income) {
                $transactionsByPeriod .= sprintf(
                        '%s: +%s %s',
                        $income->getDate()->format('d.m.Y H:i:s'),
                        $income->getAmount(),
                        $income->getCurrency(),
                    ) . PHP_EOL;
            }

            $expenses = $this->expensiveRepository->findByBetweenDates(
                $transactionsInfoDto->getDateFrom(),
                $transactionsInfoDto->getDateTo()
            );

            foreach ($expenses as $expense) {
                $transactionsByPeriod .= sprintf(
                        '%s: %s %s',
                        $expense->getDate()->format('d.m.Y H:i:s'),
                        $expense->getAmount(),
                        $expense->getCurrency(),
                    ) . PHP_EOL;
            }
        } catch (Exception) {
            throw new GetTransactionsDataException();
        }

        return $transactionsByPeriod;
    }
}
