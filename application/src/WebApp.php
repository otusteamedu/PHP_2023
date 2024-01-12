<?php

declare(strict_types=1);

namespace Gesparo\Homework;

use Gesparo\Homework\Application\ControllerGetter;
use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\Factory\AMQPMessageFromBankStatementRequestFactory;
use Gesparo\Homework\Application\Factory\ApiDocsServiceFactory;
use Gesparo\Homework\Application\Factory\CheckFinishedMessageServiceFactory;
use Gesparo\Homework\Application\Factory\ConsumerBankStatementResponseFactory;
use Gesparo\Homework\Application\Factory\EnvManagerFactory;
use Gesparo\Homework\Application\Factory\PublisherBankStatementRequestFactory;
use Gesparo\Homework\Application\Factory\RabbitConnectionFactory;
use Gesparo\Homework\Application\Factory\SendMessageServiceFactory;
use Gesparo\Homework\Application\Factory\TransactionFactory;
use Gesparo\Homework\Application\PathHelper;
use Gesparo\Homework\Infrastructure\Controller\AbstractController;
use Gesparo\Homework\Infrastructure\ExceptionHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WebApp implements App
{
    public function run(string $rootPath): void
    {
        try {
            $pathHelper = $this->getPathHelper($rootPath);
            $request = $this->getRequest();
            $urlMatcher = $this->getUrlMatcher(
                $request,
                $this->getRoutesCollection($pathHelper)
            );
            $routeAttributes = $urlMatcher->match($request->getPathInfo());
            $envManager = $this->getEnvManager($pathHelper);
            $rabbitConnection = $this->getRabbitConnection($envManager);
            $bankStatementRequestFactory = $this->getBankStatementRequestFactory();
            $amqMessageFromBankStatementRequestFactory = $this->getAMQPMessageFromBankStatementRequestFactory();
            $validator = $this->getValidator();
            $sendMessageServiceFactory = $this->getSendMessageServiceFactory(
                $rabbitConnection,
                $bankStatementRequestFactory,
                $amqMessageFromBankStatementRequestFactory,
                $envManager,
                $validator
            );
            $checkFinishedMessageServiceFactory = $this->getCheckFinishedMessageServiceFactory(
                $rabbitConnection,
                $envManager,
                $this->getTransactionFactory(),
                $this->getConsumerBankStatementResponseFactory(),
                $validator
            );
            $apiDocsServiceFactory = $this->getApiDocsServiceFactory($pathHelper);
            $controller = $this->getController(
                $request,
                $sendMessageServiceFactory,
                $checkFinishedMessageServiceFactory,
                $apiDocsServiceFactory,
                $routeAttributes['_controller']
            );

            foreach ($routeAttributes as $key => $value) {
                $request->attributes->set($key, $value);
            }

            $response = $controller->{$routeAttributes['_method']}();
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

    /**
     * @throws \Exception
     */
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

    private function getSendMessageServiceFactory(
        AMQPStreamConnection $rabbitConnection,
        PublisherBankStatementRequestFactory $bankStatementRequestFactory,
        AMQPMessageFromBankStatementRequestFactory $amqMessageFromBankStatementRequestFactory,
        EnvManager $envManager,
        ValidatorInterface $validator
    ): SendMessageServiceFactory {
        return new SendMessageServiceFactory(
            $rabbitConnection,
            $bankStatementRequestFactory,
            $amqMessageFromBankStatementRequestFactory,
            $envManager,
            $validator
        );
    }

    private function getExceptionHandler(): ExceptionHandler
    {
        return new ExceptionHandler();
    }

    private function getUrlMatcher(Request $request, RouteCollection $routeCollection): UrlMatcher
    {
        $context = new RequestContext();
        $context->fromRequest($request);

        return new UrlMatcher($routeCollection, $context);
    }

    private function getRoutesCollection(PathHelper $pathHelper): RouteCollection
    {
        return include $pathHelper->getRoutesPath();
    }

    private function getValidator(): ValidatorInterface
    {
        return Validation::createValidator();
    }

    private function getCheckFinishedMessageServiceFactory(
        AMQPStreamConnection $rabbitConnection,
        EnvManager $envManager,
        TransactionFactory $transactionFactory,
        ConsumerBankStatementResponseFactory $consumerFactory,
        ValidatorInterface $validator
    ): CheckFinishedMessageServiceFactory {
        return new CheckFinishedMessageServiceFactory(
            $rabbitConnection,
            $envManager,
            $transactionFactory,
            $consumerFactory,
            $validator
        );
    }

    private function getTransactionFactory(): TransactionFactory
    {
        return new TransactionFactory();
    }

    private function getConsumerBankStatementResponseFactory(): ConsumerBankStatementResponseFactory
    {
        return new ConsumerBankStatementResponseFactory();
    }

    /**
     * @throws AppException
     */
    private function getController(
        Request $request,
        SendMessageServiceFactory $sendMessageServiceFactory,
        CheckFinishedMessageServiceFactory $checkFinishedMessageServiceFactory,
        ApiDocsServiceFactory $apiDocsServiceFactory,
        string $controllerName
    ): AbstractController {
        return (new ControllerGetter(
            $request,
            $sendMessageServiceFactory,
            $checkFinishedMessageServiceFactory,
            $apiDocsServiceFactory
        ))->get($controllerName);
    }

    private function getApiDocsServiceFactory(PathHelper $pathHelper): ApiDocsServiceFactory
    {
        return new ApiDocsServiceFactory($pathHelper);
    }
}
