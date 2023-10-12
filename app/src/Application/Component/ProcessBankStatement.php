<?php

declare(strict_types=1);

namespace App\Application\Component;

use App\Domain\Constant\BankStatementStatus;
use App\Domain\Repository\BankStatementRepositoryInterface;
use App\Domain\Repository\ExpenseRepositoryInterface;
use App\Domain\Repository\FlusherInterface;
use App\Domain\Repository\IncomeRepositoryInterface;
use App\Domain\Repository\Pagination;
use App\Domain\ValueObject\Id;

final class ProcessBankStatement
{
    public function __construct(
        private readonly IncomeRepositoryInterface $incomeRepository,
        private readonly ExpenseRepositoryInterface $expenseRepository,
        private readonly EmailSenderInterface $emailSender,
        private readonly BankStatementRepositoryInterface $bankStatementRepository,
        private readonly FlusherInterface $flusher,
    ) {
    }

    public function process(
        Id $id,
        \DateTimeInterface $dateFrom,
        \DateTimeInterface $dateTo,
    ): void {
        $bankStatement = $this->bankStatementRepository->firstById($id);
        $bankStatement->setStatus(BankStatementStatus::IN_PROCESS);
        $this->flusher->flush();

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

        $this->emailSender->send($bankStatement->getUser()->getEmail(), 'Bank Statement', $statement);
        $bankStatement->setStatus(BankStatementStatus::WAS_SENT);
        $this->flusher->flush();
    }
}
