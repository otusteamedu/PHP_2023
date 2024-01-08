<?php

declare(strict_types=1);

namespace App\Application\Component;

use App\Entity\ValueObject\ChatId;
use App\Infrastructure\Component\TelegramSender;
use App\Infrastructure\Repository\ExpenseRepository;
use App\Infrastructure\Repository\IncomeRepository;

class ProcessBankStatement
{
    public function __construct(
        readonly IncomeRepository $incomeRepository,
        readonly ExpenseRepository $expenseRepository,
        readonly TelegramSender $sender,
    ) {
    }

    public function process(
        ChatId $chatId,
        \DateTimeInterface $dateFrom,
        \DateTimeInterface $dateTo,
    ): void {
        $statement = '';

        $incomes = $this->incomeRepository->findByBetweenDates($dateFrom, $dateTo);
        foreach ($incomes as $income) {
            $statement .= sprintf(
                '%s: +%s %s',
                $income->getDate()->format('d.m.Y H:i:s'),
                $income->getAmount(),
                $income->getCurrency(),
            ) . PHP_EOL;
        }

        $expenses = $this->expenseRepository->findByBetweenDates($dateFrom, $dateTo);
        foreach ($expenses as $expense) {
            $statement .= sprintf(
                '%s: %s %s',
                $expense->getDate()->format('d.m.Y H:i:s'),
                $expense->getAmount(),
                $expense->getCurrency(),
            ) . PHP_EOL;
        }

        $this->sender->send($chatId, $statement);
    }
}
