<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Domain\ValueObject\PublisherBankStatementResponse;

class PublisherBankStatementResponseFactory
{
    /**
     * @throws AppException
     */
    public function create(
        string $accountNumber,
        \DateTime $startDate,
        \DateTime $endDate,
        string $messageId,
        string $status,
        string $reason = '',
        array $transactions = []
    ): PublisherBankStatementResponse
    {
        return new PublisherBankStatementResponse(
            $accountNumber,
            $startDate,
            $endDate,
            $messageId,
            $status,
            $reason,
            $transactions
        );
    }
}
