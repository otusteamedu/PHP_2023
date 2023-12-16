<?php

declare(strict_types=1);

namespace Gesparo\Homework;

use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Factory\ConsumerBankStatementRequestFactory;
use Gesparo\Homework\Application\Factory\EnvManagerFactory;
use Gesparo\Homework\Application\Factory\RabbitConnectionFactory;
use Gesparo\Homework\Application\Factory\TelegramManagerFactory;
use Gesparo\Homework\Application\PathHelper;
use Gesparo\Homework\Application\Service\ReceiveMessageService;
use Gesparo\Homework\Application\TelegramManager;
use Gesparo\Homework\Domain\OutputInterface;
use Gesparo\Homework\Infrastructure\Command\ReceiveMessageCommand;
use Gesparo\Homework\Infrastructure\ConsoleOutputHelper;
use Gesparo\Homework\Infrastructure\ExceptionHandler;
use Longman\TelegramBot\Exception\TelegramException;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsoleApp implements App
{
    public function run(string $rootPath): void
    {
        try {
            $pathHelper = $this->getPathHelper($rootPath);
            $envManager = $this->getEnvManager($pathHelper);
            $telegramManager = $this->getTelegramManager($envManager);
            $rabbitConnection = $this->getRabbitConnection($envManager);
            $bankStatementRequestFactory = $this->getBankStatementRequestFactory();
            $output = $this->getOutput();
            $receiveMessageService = $this->getReceiveMessageService(
                $envManager,
                $rabbitConnection,
                $bankStatementRequestFactory,
                $telegramManager,
                $output
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

    /**
     * @throws TelegramException
     */
    private function getTelegramManager(EnvManager $envManager): TelegramManager
    {
        return (new TelegramManagerFactory($envManager))->create();
    }

    private function getReceiveMessageService(
        EnvManager $envManager,
        AMQPStreamConnection $rabbitConnection,
        ConsumerBankStatementRequestFactory $bankStatementRequestFactory,
        TelegramManager $telegramManager,
        OutputInterface $output
    ): ReceiveMessageService {
        return new ReceiveMessageService($envManager, $rabbitConnection, $bankStatementRequestFactory, $telegramManager, $output);
    }

    private function getCommand(ReceiveMessageService $receiveMessageService): ReceiveMessageCommand
    {
        return new ReceiveMessageCommand($receiveMessageService);
    }

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
}
