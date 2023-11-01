<?php

declare(strict_types=1);

namespace Gesparo\HW;

use Gesparo\HW\Controller\AddController;
use Gesparo\HW\Controller\ClearController;
use Gesparo\HW\Controller\GetController;
use Gesparo\HW\Storage\BaseStorageFacade;
use Gesparo\HW\Storage\StorageStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class ControllerNavigationStrategy
{
    private UrlMatcher $matcher;
    private Request $request;
    private EnvManager $envManager;

    public function __construct(UrlMatcher $matcher, Request $request, EnvManager $envManager)
    {
        $this->request = $request;
        $this->matcher = $matcher;
        $this->envManager = $envManager;
    }

    /**
     * @throws AppException
     * @throws \RedisException
     */
    public function run(): Response
    {
        $controller = $this->getController();

        switch ($controller) {
            case AddController::class:
            case GetController::class:
                return (new $controller($this->request, $this->getStorageFacade()))->run();
            case ClearController::class:
                return (new $controller($this->getStorageFacade()))->run();
            default:
                return (new $controller())->run();
        }
    }

    private function getController(): string
    {
        return $this->matcher->match($this->request->getPathInfo())['controller'];
    }

    /**
     * @throws AppException
     * @throws \RedisException
     */
    private function getStorageFacade(): BaseStorageFacade
    {
        return (new StorageStrategy($this->envManager))->getStorage();
    }
}
