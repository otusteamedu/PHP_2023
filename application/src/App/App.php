<?php

declare(strict_types=1);

namespace Gesparo\HW\App;

use Gesparo\HW\Controller\ControllerInterface;
use Gesparo\HW\Controller\SMSController;
use Gesparo\HW\Factory\SMSMessageFactory;
use Gesparo\HW\Middleware\BaseMiddleware;
use Gesparo\HW\Middleware\BlockedPhoneMiddleware;
use Gesparo\HW\Middleware\RudeWordsMiddleware;
use Gesparo\HW\ProviderSendMessageInterface;
use Gesparo\HW\Sender\SMSSender;
use Gesparo\HW\Storage\File\StorageException;
use Gesparo\HW\Storage\File\StorageFacade;
use Gesparo\HW\Storage\StoreInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class App
{
    public function run(string $rootPath): void
    {
        try {
            $pathHelper = $this->getPathHelper($rootPath);
            $request = $this->getRequest();
            $envManager = $this->getEnvManager($pathHelper);
            $urlMatcher = $this->getUrlMatcher($request, $pathHelper);
            $store = $this->getStore($pathHelper);
            $factory = $this->getFactory();
            $provider = $this->getProvider($envManager, $pathHelper, $store, $factory);
            $sender = $this->getSMSSender($provider, $factory);

            $response = $this->navigate($urlMatcher, $request, $store, $sender);
        } catch (\Throwable $e) {
            $response = (new ExceptionHandler())->handle($e);
        }

        $response->send();
    }

    private function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    private function getPathHelper(string $rootPath): PathHelper
    {
        return PathHelper::initInstance($rootPath);
    }

    /**
     * @throws AppException
     */
    private function getEnvManager(PathHelper $pathHelper): EnvManager
    {
        return (new EnvCreator($pathHelper->getEnvFilePath()))->create();
    }

    /**
     * @throws AppException
     */
    private function getUrlMatcher(Request $request, PathHelper $pathHelper): UrlMatcher
    {
        return (new UrlMatcherCreator($request, $pathHelper->getNavigationFilePath()))->create();
    }

    /**
     * @throws StorageException
     */
    private function getStore(PathHelper $pathHelper): StoreInterface
    {
        return new StorageFacade($pathHelper->getStoragePath());
    }

    private function getFactory(): SMSMessageFactory
    {
        return new SMSMessageFactory();
    }

    /**
     * @throws AppException
     */
    private function getProvider(EnvManager $envManager, PathHelper $pathHelper, StoreInterface $store, SMSMessageFactory $factory): ProviderSendMessageInterface
    {
        $providerStrategy = new ProviderAdapterStrategy($envManager, $pathHelper);
        $modeStrategy = new ModeStrategy($envManager, $providerStrategy, $store, $factory);

        return $modeStrategy->get();
    }

    private function getSMSSender(ProviderSendMessageInterface $provider, SMSMessageFactory $factory): SMSSender
    {
        return new SMSSender($provider, $factory);
    }

    private function navigate(UrlMatcher $matcher, Request $request, StoreInterface $store, SMSSender $sender): Response
    {
        $controller = (new ControllerNavigationStrategy($matcher, $request, $store, $sender))->get();
        $middleware = $this->getMiddleware($controller);

        $middleware?->handle($request);

        return $controller->run();
    }

    private function getMiddleware(ControllerInterface $controller): ?BaseMiddleware
    {
        if ($controller instanceof SMSController) {
            $blockedPhoneMiddleware = new BlockedPhoneMiddleware();
            $rudeWordsMiddleware = new RudeWordsMiddleware();

            $blockedPhoneMiddleware->setNext($rudeWordsMiddleware);

            return $blockedPhoneMiddleware;
        }

        return null;
    }
}
