<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Domain;
use Gesparo\Homework\Domain\ValueObject\ConsumerBankStatementRequest;

class ConsumerBankStatementRequestFactory
{
    /**
     * @throws AppException
     */
    public function create(string $accountNumber, \DateTime $startDate, \DateTime $endDate): ConsumerBankStatementRequest
    {
        return new ConsumerBankStatementRequest($accountNumber, $startDate, $endDate);
    }
}
