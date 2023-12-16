<?php

declare(strict_types=1);

namespace Gesparo\Homework\Service;

use Gesparo\Homework\BankStatementRequestFactory;
use Gesparo\Homework\EnvManager;
use Gesparo\Homework\TelegramManager;
use Gesparo\Homework\ValueObject\BankStatementRequest;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ReceiveMessageService
{
    public function __construct(
        private readonly EnvManager $envManager,
        private readonly AMQPStreamConnection $connection,
        private readonly BankStatementRequestFactory $bankStatementRequestFactory,
        private readonly TelegramManager $telegramManagerFactory
    )
    {
    }

    public function receive(): void
    {
        $channel = $this->connection->channel();

        $channel->queue_declare($this->envManager->getChannelName(), false, false, false, false);

        $callback = function ($msg) {
            $body = json_decode($msg->body, true, 512, JSON_THROW_ON_ERROR);

            $bankStatementRequest = $this->bankStatementRequestFactory->create(
                $body['accountNumber'],
                \DateTime::createFromFormat('Y-m-d', $body['startDate']),
                \DateTime::createFromFormat('Y-m-d', $body['endDate'])
            );

            $this->telegramManagerFactory->sendMessage($this->getMessageForTelegram($bankStatementRequest));
        };

        $channel->basic_consume($this->envManager->getChannelName(), '', false, true, false, false, $callback);

        $channel->consume();
    }

    private function getMessageForTelegram(BankStatementRequest $request): string
    {
        return sprintf(
            "Request for bank statement with account number '%s' and start date '%s' and end date '%s'",
            $request->getAccountNumber(),
            $request->getStartDate()->format('Y-m-d'),
            $request->getEndDate()->format('Y-m-d')
        );
    }
}