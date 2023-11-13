<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure;

use Gesparo\HW\Application\ConditionFactory;
use Gesparo\HW\Application\EventFactory;
use Gesparo\HW\Application\UseCase\AddEventsUseCase;
use Gesparo\HW\Application\UseCase\ClearEventsUseCase;
use Gesparo\HW\Application\UseCase\GetEventUseCase;
use Gesparo\HW\Infrastructure\App\AppException;
use Gesparo\HW\Infrastructure\Controller\AddController;
use Gesparo\HW\Infrastructure\Controller\ClearController;
use Gesparo\HW\Infrastructure\Controller\ControllerInterface;
use Gesparo\HW\Infrastructure\Controller\GetController;
use Gesparo\HW\Infrastructure\Request\AddEventRequestGetter;
use Gesparo\HW\Infrastructure\Request\GetRequestGetter;
use Gesparo\HW\Infrastructure\Storage\StorageStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class ControllerNavigationStrategy
{
    private UrlMatcher $matcher;
    private Request $request;
    private StorageStrategy $storageStrategy;

    public function __construct(UrlMatcher $matcher, Request $request, StorageStrategy $storageStrategy)
    {
        $this->request = $request;
        $this->matcher = $matcher;
        $this->storageStrategy = $storageStrategy;
    }

    /**
     * @return ControllerInterface
     * @throws AppException
     * @throws \RedisException
     */
    public function get(): ControllerInterface
    {
        $controller = $this->getController();

        return match ($controller) {
            AddController::class => new AddController(
                new AddEventRequestGetter($this->request),
                new AddEventsUseCase($this->storageStrategy->getStorage(), new EventFactory(), new ConditionFactory())
            ),
            GetController::class => new GetController(
                new GetRequestGetter($this->request),
                new GetEventUseCase($this->storageStrategy->getStorage())
            ),
            ClearController::class => new ClearController(new ClearEventsUseCase($this->storageStrategy->getStorage())),
            default => new $controller(),
        };
    }

    private function getController(): string
    {
        return $this->matcher->match($this->request->getPathInfo())['controller'];
    }
}
