<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Domain\ValueObject\Transaction;

class TransactionFactory
{
    /**
     * @throws AppException
     */
    public function create(
        string $accountNumber,
        string $amount,
        string $currency,
        \DateTime $date,
        string $description
    ): Transaction {
        return new Transaction(
            $accountNumber,
            $amount,
            $currency,
            $date,
            $description
        );
    }
}
