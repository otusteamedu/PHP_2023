<?php

declare(strict_types=1);

namespace Gesparo\HW\App;

use Gesparo\HW\Controller\ControllerInterface;
use Gesparo\HW\Controller\QueueController;
use Gesparo\HW\Controller\SMSController;
use Gesparo\HW\Sender\SMSSender;
use Gesparo\HW\Storage\StoreInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class ControllerNavigationStrategy
{
    private UrlMatcher $matcher;
    private Request $request;
    private StoreInterface $store;
    private SMSSender $sender;

    public function __construct(UrlMatcher $matcher, Request $request, StoreInterface $store, SMSSender $sender)
    {
        $this->matcher = $matcher;
        $this->request = $request;
        $this->store = $store;
        $this->sender = $sender;
    }

    public function get(): ControllerInterface
    {
        $controller = $this->getController();

        return match ($controller) {
            QueueController::class => new QueueController($this->store),
            SMSController::class => new SMSController($this->sender, $this->request),
            default => new $controller(),
        };
    }

    private function getController(): string
    {
        return $this->matcher->match($this->request->getPathInfo())['controller'];
    }
}
