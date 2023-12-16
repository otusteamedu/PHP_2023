<?php

declare(strict_types=1);

namespace Gesparo\Homework;

use Gesparo\Homework\Command\ReceiveMessageCommand;
use Gesparo\Homework\Service\ReceiveMessageService;
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
            $receiveMessageService = $this->getReceiveMessageService(
                $envManager,
                $rabbitConnection,
                $bankStatementRequestFactory,
                $telegramManager
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
        BankStatementRequestFactory $bankStatementRequestFactory,
        TelegramManager $telegramManager
    ): ReceiveMessageService
    {
        return new ReceiveMessageService($envManager, $rabbitConnection, $bankStatementRequestFactory, $telegramManager);
    }

    private function getCommand(ReceiveMessageService $receiveMessageService): ReceiveMessageCommand
    {
        return new ReceiveMessageCommand($receiveMessageService);
    }

    private function getRabbitConnection(EnvManager $envManager): AMQPStreamConnection
    {
        return (new RabbitConnectionFactory($envManager))->create();
    }

    private function getBankStatementRequestFactory(): BankStatementRequestFactory
    {
        return new BankStatementRequestFactory();
    }

    private function getExceptionHandler(): ExceptionHandler
    {
        return new ExceptionHandler();
    }
}