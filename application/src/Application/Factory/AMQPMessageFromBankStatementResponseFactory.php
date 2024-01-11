<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\Domain\ValueObject\PublisherBankStatementResponse;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPMessageFromBankStatementResponseFactory
{
    /**
     * @throws \JsonException
     */
    public function create(PublisherBankStatementResponse $response): AMQPMessage
    {
        $simplifiedTransactions = [];

        foreach ($response->getTransactions() as $transaction) {
            $simplifiedTransactions[] = [
                'accountNumber' => $transaction->getAccountNumber(),
                'date' => $transaction->getDate()->format('Y-m-d H:i:s'),
                'amount' => $transaction->getAmount(),
                'currency' => $transaction->getCurrency(),
                'description' => $transaction->getDescription(),
            ];
        }

        $message = json_encode(
            [
                'accountNumber' => $response->getAccountNumber(),
                'startDate' => $response->getStartDate()->format('Y-m-d'),
                'endDate' => $response->getEndDate()->format('Y-m-d'),
                'status' => $response->getStatus(),
                'reason' => $response->getReason(),
                'transactions' => $simplifiedTransactions,
            ],
            JSON_THROW_ON_ERROR
        );

        return new AMQPMessage($message);
    }
}
