<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Service;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Factory\AMQPMessageFromBankStatementRequestFactory;
use Gesparo\Homework\Application\Factory\PublisherBankStatementRequestFactory;
use Gesparo\Homework\Application\Request\SendMessageRequest;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class SendMessageService
{
    public function __construct(
        private readonly AMQPStreamConnection                       $rabbitConnection,
        private readonly PublisherBankStatementRequestFactory       $bankStatementRequestFactory,
        private readonly AMQPMessageFromBankStatementRequestFactory $amqMessageFromBankStatementRequestFactory,
        private readonly EnvManager                                 $envManager
    )
    {
    }

    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function send(SendMessageRequest $request): void
    {
        $this->validateRequest($request);

        $bankStatementRequest = $this->bankStatementRequestFactory->create(
            $request->accountNumber,
            \DateTime::createFromFormat('Y-m-d', $request->startDate),
            \DateTime::createFromFormat('Y-m-d', $request->endDate)
        );

        $channel = $this->rabbitConnection->channel();
        $message = $this->amqMessageFromBankStatementRequestFactory->create($bankStatementRequest);

        $channel->basic_publish($message, '', $this->envManager->getChannelName());

        $channel->close();
        $this->rabbitConnection->close();
    }

    /**
     * @throws AppException
     */
    private function validateRequest(SendMessageRequest $request): void
    {
        if (null === $request->accountNumber) {
            throw AppException::validationError('Account number is required');
        }

        if (null === $request->startDate) {
            throw AppException::validationError('Start date is required');
        }

        if (null === $request->endDate) {
            throw AppException::validationError('End date is required');
        }

        $startDate = \DateTime::createFromFormat('Y-m-d', $request->startDate);

        if (false === $startDate) {
            throw AppException::validationError('Start date is invalid');
        }

        $endDate = \DateTime::createFromFormat('Y-m-d', $request->endDate);

        if (false === $endDate) {
            throw AppException::validationError('End date is invalid');
        }

        if ($startDate > $endDate) {
            throw AppException::validationError('Start date cannot be greater than end date');
        }
    }
}