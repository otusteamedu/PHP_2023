<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\Domain\ValueObject\PublisherBankStatementRequest;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPMessageFromBankStatementRequestFactory
{
    /**
     * @throws \JsonException
     */
    public function create(PublisherBankStatementRequest $bankStatementRequest): AMQPMessage
    {
        $message = json_encode(
            [
                'accountNumber' => $bankStatementRequest->getAccountNumber(),
                'startDate' => $bankStatementRequest->getStartDate()->format('Y-m-d'),
                'endDate' => $bankStatementRequest->getEndDate()->format('Y-m-d'),
            ],
            JSON_THROW_ON_ERROR
        );

        return new AMQPMessage($message);
    }
}
