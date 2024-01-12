<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Domain\ValueObject\ConsumerBankStatementResponse;

class ConsumerBankStatementResponseFactory
{
    /**
     * @throws AppException
     */
    public function create(
        string $accountNumber,
        \DateTime $startDate,
        \DateTime $endDate,
        string $status,
        string $reason = '',
        array $transactions = []
    ): ConsumerBankStatementResponse {
        return new ConsumerBankStatementResponse($accountNumber, $startDate, $endDate, $status, $reason, $transactions);
    }
}
