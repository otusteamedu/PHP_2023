<?php

declare(strict_types=1);

namespace Gesparo\Homework;

class BankStatementRequestFactory
{
    /**
     * @throws AppException
     */
    public function create(string $accountNumber, \DateTime $startDate, \DateTime $endDate): ValueObject\BankStatementRequest
    {
        return new ValueObject\BankStatementRequest($accountNumber, $startDate, $endDate);
    }
}