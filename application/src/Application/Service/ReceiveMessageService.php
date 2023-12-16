<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Service;

use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Factory\ConsumerBankStatementRequestFactory;
use Gesparo\Homework\Application\Factory\PublisherBankStatementRequestFactory;
use Gesparo\Homework\Application\TelegramManager;
use Gesparo\Homework\Domain\OutputInterface;
use Gesparo\Homework\Domain\ValueObject\ConsumerBankStatementRequest;
use Gesparo\Homework\Domain\ValueObject\PublisherBankStatementRequest;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ReceiveMessageService
{
    public function __construct
    (
        private readonly EnvManager                          $envManager,
        private readonly AMQPStreamConnection                $connection,
        private readonly ConsumerBankStatementRequestFactory $bankStatementRequestFactory,
        private readonly TelegramManager                     $telegramManagerFactory,
        private readonly OutputInterface                     $output
    )
    {
    }

    /**
     * @throws \ErrorException
     */
    public function receive(): void
    {
        $channel = $this->connection->channel();

        $channel->queue_declare($this->envManager->getChannelName(), false, false, false, false);

        $this->output->send('Waiting for messages. To exit press CTRL+C');

        $callback = function ($msg) {
            $this->output->send('Received message: ' . $msg->body . ' from queue: ' . $this->envManager->getChannelName());

            $body = json_decode($msg->body, true, 512, JSON_THROW_ON_ERROR);

            $bankStatementRequest = $this->bankStatementRequestFactory->create(
                $body['accountNumber'],
                \DateTime::createFromFormat('Y-m-d', $body['startDate']),
                \DateTime::createFromFormat('Y-m-d', $body['endDate'])
            );

            $this->telegramManagerFactory->sendMessage($this->getMessageForTelegram($bankStatementRequest));

            $this->output->send('Message sent to telegram');
        };

        $channel->basic_consume($this->envManager->getChannelName(), '', false, true, false, false, $callback);

        $channel->consume();
    }

    private function getMessageForTelegram(ConsumerBankStatementRequest $request): string
    {
        return sprintf(
            "Request for bank statement with account number '%s' and start date '%s' and end date '%s'",
            $request->getAccountNumber(),
            $request->getStartDate()->format('Y-m-d'),
            $request->getEndDate()->format('Y-m-d')
        );
    }
}
