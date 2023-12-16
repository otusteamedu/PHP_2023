<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Domain\ValueObject\PublisherBankStatementRequest;

class PublisherBankStatementRequestFactory
{
    /**
     * @throws AppException
     */
    public function create(string $accountNumber, \DateTime $startDate, \DateTime $endDate): PublisherBankStatementRequest
    {
        return new PublisherBankStatementRequest($accountNumber, $startDate, $endDate);
    }
}
