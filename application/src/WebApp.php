<?php

declare(strict_types=1);

namespace Gesparo\Homework;

use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Factory\AMQPMessageFromBankStatementRequestFactory;
use Gesparo\Homework\Application\Factory\PublisherBankStatementRequestFactory;
use Gesparo\Homework\Application\Factory\EnvManagerFactory;
use Gesparo\Homework\Application\Factory\RabbitConnectionFactory;
use Gesparo\Homework\Application\PathHelper;
use Gesparo\Homework\Application\Service\SendMessageService;
use Gesparo\Homework\Infrastructure\Controller\IndexController;
use Gesparo\Homework\Infrastructure\ExceptionHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\HttpFoundation\Request;

class WebApp implements App
{
    public function run(string $rootPath): void
    {
        try {
            $pathHelper = $this->getPathHelper($rootPath);
            $envManager = $this->getEnvManager($pathHelper);
            $rabbitConnection = $this->getRabbitConnection($envManager);
            $bankStatementRequestFactory = $this->getBankStatementRequestFactory();
            $amqMessageFromBankStatementRequestFactory = $this->getAMQPMessageFromBankStatementRequestFactory();
            $sendMessageService = $this->getSendMessageService(
                $rabbitConnection,
                $bankStatementRequestFactory,
                $amqMessageFromBankStatementRequestFactory,
                $envManager
            );
            $controller = $this->getController(
                $sendMessageService,
                $this->getRequest()
            );

            $response = $controller->index();
        } catch (\Throwable $exception) {
            $response = $this->getExceptionHandler()->handle($exception);
        }

        $response->send();
    }

    /**
     * @throws AppException
     */
    private function getPathHelper(string $rootPath): PathHelper
    {
        PathHelper::init($rootPath);

        return PathHelper::getInstance();
    }

    private function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    /**
     * @throws AppException
     */
    private function getEnvManager(PathHelper $pathHelper): EnvManager
    {
        return (new EnvManagerFactory($pathHelper))->create();
    }

    private function getRabbitConnection(EnvManager $envManager): AMQPStreamConnection
    {
        return (new RabbitConnectionFactory($envManager))->create();
    }

    private function getBankStatementRequestFactory(): PublisherBankStatementRequestFactory
    {
        return new PublisherBankStatementRequestFactory();
    }

    private function getAMQPMessageFromBankStatementRequestFactory(): AMQPMessageFromBankStatementRequestFactory
    {
        return new AMQPMessageFromBankStatementRequestFactory();
    }

    private function getSendMessageService(
        AMQPStreamConnection $rabbitConnection,
        PublisherBankStatementRequestFactory $bankStatementRequestFactory,
        AMQPMessageFromBankStatementRequestFactory $amqMessageFromBankStatementRequestFactory,
        EnvManager $envManager
    ): SendMessageService {
        return new SendMessageService(
            $rabbitConnection,
            $bankStatementRequestFactory,
            $amqMessageFromBankStatementRequestFactory,
            $envManager
        );
    }

    private function getController(SendMessageService $sendMessageService, Request $request): IndexController
    {
        return new IndexController(
            $sendMessageService,
            $request
        );
    }

    private function getExceptionHandler(): ExceptionHandler
    {
        return new ExceptionHandler();
    }
}

