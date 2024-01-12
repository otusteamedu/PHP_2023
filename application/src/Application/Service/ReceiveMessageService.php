<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Service;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Factory\AMQPMessageFromBankStatementResponseFactory;
use Gesparo\Homework\Application\Factory\ConsumerBankStatementRequestFactory;
use Gesparo\Homework\Application\Factory\PublisherBankStatementResponseFactory;
use Gesparo\Homework\Application\StatementManager;
use Gesparo\Homework\Domain\OutputInterface;
use Gesparo\Homework\Domain\ValueObject\ConsumerBankStatementRequest;
use Gesparo\Homework\Domain\ValueObject\PublisherBankStatementResponse;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ReceiveMessageService
{
    public function __construct(
        private readonly EnvManager $envManager,
        private readonly AMQPStreamConnection $connection,
        private readonly ConsumerBankStatementRequestFactory $bankStatementRequestFactory,
        private readonly OutputInterface $output,
        private readonly StatementManager $statementManager,
        private readonly PublisherBankStatementResponseFactory $publisherBankStatementResponseFactory,
        private readonly AMQPMessageFromBankStatementResponseFactory $amqpMessageFactory
    ) {
    }

    /**
     * @throws \ErrorException
     */
    public function receive(): void
    {
        $receiveChannel = $this->connection->channel();
        $sendChannel = $this->connection->channel();

        $receiveChannel->queue_declare($this->envManager->getInputChannelName(), false, false, false, false);
        $sendChannel->queue_declare($this->envManager->getOutputChannelName(), false, false, false, false);

        $this->output->send('Waiting for messages. To exit press CTRL+C');

        $callback = function (AMQPMessage $msg) use ($sendChannel) {
            $this->output->send("Received message '{$msg->get('message_id')}': $msg->body from queue: {$this->envManager->getInputChannelName()}");

            $body = json_decode($msg->body, true, 512, JSON_THROW_ON_ERROR);

            $bankStatementRequest = $this->bankStatementRequestFactory->create(
                $body['accountNumber'],
                \DateTime::createFromFormat('Y-m-d', $body['startDate']),
                \DateTime::createFromFormat('Y-m-d', $body['endDate']),
                $msg->get('message_id')
            );

            $response = $this->getResponse($bankStatementRequest);
            $message = $this->amqpMessageFactory->create($response);

            $message->set('message_id', $bankStatementRequest->getMessageId());

            $sendChannel->basic_publish($message, '', $this->envManager->getOutputChannelName());

            if ($response->getStatus() === PublisherBankStatementResponse::STATUS_SUCCESS) {
                $this->output->send('Message was processed successfully');
            } else {
                $this->output->send('Statement request was not successful because of dummy error');
            }
        };

        $receiveChannel->basic_consume($this->envManager->getInputChannelName(), '', false, true, false, false, $callback);

        $receiveChannel->consume();
    }

    /**
     * @throws AppException
     * @throws \Exception
     */
    private function getResponse(ConsumerBankStatementRequest $bankStatementRequest): PublisherBankStatementResponse
    {
        try {
            $transactions = $this->statementManager->manage($bankStatementRequest);

            return $this->publisherBankStatementResponseFactory->create(
                $bankStatementRequest->getAccountNumber(),
                $bankStatementRequest->getStartDate(),
                $bankStatementRequest->getEndDate(),
                $bankStatementRequest->getMessageId(),
                PublisherBankStatementResponse::STATUS_SUCCESS,
                '',
                $transactions
            );
        } catch (AppException $exception) {
            if ($exception->getCode() === AppException::STATEMENT_REQUEST_WAS_NOT_SUCCESSFUL) {
                return $this->publisherBankStatementResponseFactory->create(
                    $bankStatementRequest->getAccountNumber(),
                    $bankStatementRequest->getStartDate(),
                    $bankStatementRequest->getEndDate(),
                    $bankStatementRequest->getMessageId(),
                    PublisherBankStatementResponse::STATUS_FAILED,
                    "Don't worry. This is dummy error with failed status, that shows how messages with errors are handled"
                );
            }

            throw $exception;
        }
    }
}
