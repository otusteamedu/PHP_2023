<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Service\SendMessageService;
use Gesparo\Homework\Domain\AMQPMessageCreationInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SendMessageServiceFactory
{
    public function __construct(
        private readonly AMQPStreamConnection $rabbitConnection,
        private readonly PublisherBankStatementRequestFactory $bankStatementRequestFactory,
        private readonly AMQPMessageCreationInterface $amqpMessageFactory,
        private readonly EnvManager $envManager,
        private readonly ValidatorInterface $validator
    ) {
    }

    public function create(): SendMessageService
    {
        return new SendMessageService(
            $this->rabbitConnection,
            $this->bankStatementRequestFactory,
            $this->amqpMessageFactory,
            $this->envManager,
            $this->validator
        );
    }
}
