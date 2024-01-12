<?php

declare(strict_types=1);

namespace Gesparo\Homework;

use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Factory\AMQPMessageFromBankStatementResponseFactory;
use Gesparo\Homework\Application\Factory\ConsumerBankStatementRequestFactory;
use Gesparo\Homework\Application\Factory\EnvManagerFactory;
use Gesparo\Homework\Application\Factory\PublisherBankStatementResponseFactory;
use Gesparo\Homework\Application\Factory\RabbitConnectionFactory;
use Gesparo\Homework\Application\Factory\TransactionFactory;
use Gesparo\Homework\Application\PathHelper;
use Gesparo\Homework\Application\Service\ReceiveMessageService;
use Gesparo\Homework\Application\StatementManager;
use Gesparo\Homework\Domain\OutputInterface;
use Gesparo\Homework\Infrastructure\Command\ReceiveMessageCommand;
use Gesparo\Homework\Infrastructure\ConsoleOutputHelper;
use Gesparo\Homework\Infrastructure\ExceptionHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsoleApp implements App
{
    public function run(string $rootPath): void
    {
        try {
            $envManager = $this->getEnvManager($this->getPathHelper($rootPath));
            $receiveMessageService = $this->getReceiveMessageService(
                $envManager,
                $this->getRabbitConnection($envManager),
                $this->getBankStatementRequestFactory(),
                $this->getOutput(),
                $this->getStatementManager($this->getTransactionFactory()),
                $this->getPublisherBankStatementResponseFactory(),
                $this->getAMQPMessageFromBankStatementResponseFactory()
            );
            $command = $this->getCommand($receiveMessageService);

            $command->execute();
        } catch (\Throwable $exception) {
            $response = $this->getExceptionHandler()->handle($exception);

            $response->send();
        }
    }

    /**
     * @throws AppException
     */
    private function getPathHelper(string $rootPath): PathHelper
    {
        PathHelper::init($rootPath);

        return PathHelper::getInstance();
    }

    /**
     * @throws AppException
     */
    private function getEnvManager(PathHelper $pathHelper): EnvManager
    {
        return (new EnvManagerFactory($pathHelper))->create();
    }


    private function getReceiveMessageService(
        EnvManager $envManager,
        AMQPStreamConnection $rabbitConnection,
        ConsumerBankStatementRequestFactory $bankStatementRequestFactory,
        OutputInterface $output,
        StatementManager $statementManager,
        PublisherBankStatementResponseFactory $publisherBankStatementResponseFactory,
        AMQPMessageFromBankStatementResponseFactory $amqpMessageFactory
    ): ReceiveMessageService {
        return new ReceiveMessageService(
            $envManager,
            $rabbitConnection,
            $bankStatementRequestFactory,
            $output,
            $statementManager,
            $publisherBankStatementResponseFactory,
            $amqpMessageFactory
        );
    }

    private function getCommand(ReceiveMessageService $receiveMessageService): ReceiveMessageCommand
    {
        return new ReceiveMessageCommand($receiveMessageService);
    }

    /**
     * @throws \Exception
     */
    private function getRabbitConnection(EnvManager $envManager): AMQPStreamConnection
    {
        return (new RabbitConnectionFactory($envManager))->create();
    }

    private function getBankStatementRequestFactory(): ConsumerBankStatementRequestFactory
    {
        return new ConsumerBankStatementRequestFactory();
    }

    private function getExceptionHandler(): ExceptionHandler
    {
        return new ExceptionHandler();
    }

    private function getOutput(): OutputInterface
    {
        return new ConsoleOutputHelper();
    }

    private function getTransactionFactory(): TransactionFactory
    {
        return new TransactionFactory();
    }

    private function getStatementManager(TransactionFactory $transactionFactory): StatementManager
    {
        return new StatementManager($transactionFactory);
    }

    private function getPublisherBankStatementResponseFactory(): PublisherBankStatementResponseFactory
    {
        return new PublisherBankStatementResponseFactory();
    }

    private function getAMQPMessageFromBankStatementResponseFactory(): AMQPMessageFromBankStatementResponseFactory
    {
        return new AMQPMessageFromBankStatementResponseFactory();
    }
}
