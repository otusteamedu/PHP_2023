<?php

declare(strict_types=1);

namespace App\Application\Component;

use App\Domain\Repository\ExpenseRepositoryInterface;
use App\Domain\Repository\IncomeRepositoryInterface;
use App\Domain\Repository\Pagination;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Number;

final class ProcessBankStatement
{
    public function __construct(
        private readonly IncomeRepositoryInterface $incomeRepository,
        private readonly ExpenseRepositoryInterface $expenseRepository,
        private readonly EmailSenderInterface $emailSender,
    ) {
    }

    public function process(
        Email $email,
        \DateTimeInterface $dateFrom,
        \DateTimeInterface $dateTo,
    ): void {
        $statement = "";
        $pagination = new Pagination(1, 50, null);

        do {
            $incomes = $this->incomeRepository->partByDateRange($dateFrom, $dateTo, $pagination);

            foreach ($incomes as $income) {
                $statement .= sprintf(
                    '%s: +%s %s',
                    $income->getDateTime()->format('d.m.Y H:i:s'),
                    $income->getAmount()->getAmount(),
                    $income->getAmount()->getCurrency(),
                ) . PHP_EOL;
            }

            $pagination->incrementPage();
        } while (count($incomes) === $pagination->getPerPage());

        $pagination = new Pagination(1, 50, null);

        do {
            $expenses = $this->expenseRepository->partByDateRange($dateFrom, $dateTo, $pagination);

            foreach ($expenses as $expense) {
                $statement .= sprintf(
                    '%s: -%s %s',
                    $expense->getDateTime()->format('d.m.Y H:i:s'),
                    $expense->getAmount()->getAmount(),
                    $expense->getAmount()->getCurrency(),
                ) . PHP_EOL;
            }

            $pagination->incrementPage();
        } while (count($expenses) === $pagination->getPerPage());

        $this->emailSender->send($email, 'Bank Statement', $statement);
    }
}
