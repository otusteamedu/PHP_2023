<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application;

use Gesparo\Homework\AppException;
use Gesparo\Homework\Application\Factory\CheckFinishedMessageServiceFactory;
use Gesparo\Homework\Application\Factory\SendMessageServiceFactory;
use Gesparo\Homework\Infrastructure\AbstractController;
use Gesparo\Homework\Infrastructure\Controller\CheckController;
use Gesparo\Homework\Infrastructure\Controller\RequestController;
use Symfony\Component\HttpFoundation\Request;

class ControllerGetter
{
    public function __construct(
        private readonly Request $request,
        private readonly SendMessageServiceFactory $sendMessageServiceFactory,
        private readonly CheckFinishedMessageServiceFactory $checkFinishedMessageServiceFactory
    )
    {
    }

    /**
     * @throws AppException
     */
    public function get(string $controllerName): AbstractController
    {
        return match ($controllerName) {
            RequestController::class => new RequestController(
                $this->request,
                $this->sendMessageServiceFactory->create()
            ),
            CheckController::class => new CheckController(
                $this->request,
                $this->checkFinishedMessageServiceFactory->create()
            ),
            default => throw AppException::invalidController($controllerName),
        };
    }
}
