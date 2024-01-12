<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Service\CheckFinishedMessageService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CheckFinishedMessageServiceFactory
{
    public function __construct(
        private readonly AMQPStreamConnection $connection,
        private readonly EnvManager $envManager,
        private readonly TransactionFactory $transactionFactory,
        private readonly ConsumerBankStatementResponseFactory $consumerFactory,
        private readonly ValidatorInterface $validator
    ) {
    }

    public function create(): CheckFinishedMessageService
    {
        return new CheckFinishedMessageService(
            $this->connection,
            $this->envManager,
            $this->transactionFactory,
            $this->consumerFactory,
            $this->validator
        );
    }
}
