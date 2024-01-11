<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Service;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Factory\PublisherBankStatementRequestFactory;
use Gesparo\Homework\Application\Request\SendMessageRequest;
use Gesparo\Homework\Application\Response\SendMessageResponse;
use Gesparo\Homework\Application\ViolationsExceptionTrait;
use Gesparo\Homework\Domain\AMQPMessageCreationInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SendMessageService
{
    use ViolationsExceptionTrait;

    public function __construct(
        private readonly AMQPStreamConnection $rabbitConnection,
        private readonly PublisherBankStatementRequestFactory $bankStatementRequestFactory,
        private readonly AMQPMessageCreationInterface $amqpMessageFactory,
        private readonly EnvManager $envManager,
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * @throws AppException
     * @throws \Exception
     */
    public function send(SendMessageRequest $request): SendMessageResponse
    {
        $this->validateRequest($request);

        $bankStatementRequest = $this->bankStatementRequestFactory->create(
            $request->accountNumber,
            \DateTime::createFromFormat('Y-m-d', $request->startDate),
            \DateTime::createFromFormat('Y-m-d', $request->endDate)
        );

        $channel = $this->rabbitConnection->channel();
        $message = $this->amqpMessageFactory->create($bankStatementRequest);
        $messageId = Uuid::uuid4()->toString();

        $message->set('message_id', $messageId);

        $channel->basic_publish($message, '', $this->envManager->getInputChannelName());

        $channel->close();
        $this->rabbitConnection->close();

        return new SendMessageResponse($messageId);
    }

    /**
     * @throws AppException
     */
    private function validateRequest(SendMessageRequest $request): void
    {
        $groups = new GroupSequence(['Default', 'second']);
        $input = [
            'accountNumber' => $request->accountNumber,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ];
        $constraints = new Collection([
            'accountNumber' => new Sequentially([
                new NotBlank(),
                new Length(['min' => 16, 'max' => 16]),
            ]),
            'startDate' => new Sequentially([
                new NotBlank(),
                new Date(),
            ]),
            'endDate' => new Sequentially([
                new NotBlank(),
                new Date(),
                new GreaterThan(value: $request->startDate ?? date('Y-m-d'), groups: ['second']),
            ]),
        ]);

        $violations = $this->validator->validate($input, $constraints, $groups);

        if (count($violations) > 0) {
            $this->throwViolationsException($violations);
        }
    }
}
