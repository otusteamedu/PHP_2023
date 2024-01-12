<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Service;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Factory\ConsumerBankStatementResponseFactory;
use Gesparo\Homework\Application\Factory\TransactionFactory;
use Gesparo\Homework\Application\Request\CheckFinishedMessageRequest;
use Gesparo\Homework\Application\Response\CheckFinishedMessage\CheckFinishedMessageResponse;
use Gesparo\Homework\Application\Response\CheckFinishedMessage\Transaction;
use Gesparo\Homework\Application\ViolationsExceptionTrait;
use Gesparo\Homework\Domain\ValueObject\PublisherBankStatementResponse;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CheckFinishedMessageService
{
    use ViolationsExceptionTrait;

    public function __construct(
        private readonly AMQPStreamConnection $connection,
        private readonly EnvManager $envManager,
        private readonly TransactionFactory $transactionFactory,
        private readonly ConsumerBankStatementResponseFactory $consumerFactory,
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function check(CheckFinishedMessageRequest $request): CheckFinishedMessageResponse
    {
        $this->validateRequest($request);

        $channel = $this->connection->channel();
        $finishedMessage = $this->getMessage($channel, $request->messageId, $this->envManager->getOutputChannelName());

        if ($finishedMessage === null) {
            return new CheckFinishedMessageResponse(
                CheckFinishedMessageResponse::STATUS_PROCESSING,
                null,
                null,
                null,
                null,
                []
            );
        }

        $channel->basic_ack($finishedMessage->get('delivery_tag'));

        $body = json_decode($finishedMessage->body, true, 512, JSON_THROW_ON_ERROR);
        $transactions = [];

        foreach ($body['transactions'] as $transaction) {
            $transactions[] = $this->transactionFactory->create(
                $transaction['accountNumber'],
                $transaction['amount'],
                $transaction['currency'],
                \DateTime::createFromFormat('Y-m-d H:i:s', $transaction['date']),
                $transaction['description']
            );
        }

        $response = $this->consumerFactory->create(
            $body['accountNumber'],
            \DateTime::createFromFormat('Y-m-d', $body['startDate']),
            \DateTime::createFromFormat('Y-m-d', $body['endDate']),
            $body['status'],
            $body['reason'],
            $transactions
        );

        $dtoTransactions = [];

        foreach ($response->getTransactions() as $transaction) {
            $dtoTransactions[] = new Transaction(
                $transaction->getAccountNumber(),
                $transaction->getAmount(),
                $transaction->getCurrency(),
                $transaction->getDate()->format('Y-m-d H:i:s'),
                $transaction->getDescription()
            );
        }

        return new CheckFinishedMessageResponse(
            $response->getStatus() === PublisherBankStatementResponse::STATUS_SUCCESS ?
                CheckFinishedMessageResponse::STATUS_FINISHED : CheckFinishedMessageResponse::STATUS_FAILED,
            $response->getAccountNumber(),
            $response->getStartDate()->format('Y-m-d'),
            $response->getEndDate()->format('Y-m-d'),
            $response->getReason(),
            $dtoTransactions
        );
    }

    /**
     * @throws AppException
     */
    private function validateRequest(CheckFinishedMessageRequest $request): void
    {
        $input = [
            'messageId' => $request->messageId,
        ];
        $constraints = new Collection([
            'messageId' => new Sequentially([
                new NotBlank(),
                new Uuid()
            ]),
        ]);

        $violations = $this->validator->validate($input, $constraints);

        if ($violations->count() > 0) {
            $this->throwViolationsException($violations);
        }
    }

    private function getMessage(AMQPChannel $channel, string $messageId, string $queueName): ?AMQPMessage
    {
        /** @var AMQPMessage|null $outputMessage */
        $outputMessage = $channel->basic_get($queueName);

        while ($outputMessage !== null) {
            if ($outputMessage->get('message_id') === $messageId) {
                return $outputMessage;
            }

            $outputMessage = $channel->basic_get($queueName);
        }

        return null;
    }
}
