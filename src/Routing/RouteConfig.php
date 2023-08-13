<?php

declare(strict_types=1);

namespace Ro\Php2023\Routing;

use Ro\Php2023\Controllers\EventsControllerInterface;
use Ro\Php2023\Controllers\TestingControllerInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class RouteConfig
{
    private EventsControllerInterface $eventsController;
    private TestingControllerInterface $redisController;

    public function __construct(EventsControllerInterface $eventsController, TestingControllerInterface $redisController)
    {
        $this->eventsController = $eventsController;
        $this->redisController = $redisController;
    }

    public function configureRoutes(): RouteCollection
    {
        $routes = new RouteCollection();

        $routes->add('event_create', new Route(
            '/events',
            ['_controller' => [$this->eventsController, 'add']],
            [],
            [],
            "",
            [],
            ["POST"]
        ));

        $routes->add('event_delete', new Route(
            '/events',
            ['_controller' => [$this->eventsController, 'delete']],
            [],
            [],
            "",
            [],
            ["DELETE"]
        ));

        $routes->add('event_id', new Route(
            'events/{id}',
            ['_controller' => [$this->eventsController, 'getById']],
            [],
            [],
            "",
            [],
            ["GET"]
        ));

        $routes->add('all_event', new Route(
            '/events',
            ['_controller' => [$this->eventsController, 'getAll']],
            [],
            [],
            "",
            [],
            ["GET"]
        ));

        $routes->add('getMatching', new Route(
            '/events/matching',
            ['_controller' => [$this->eventsController, 'getMatching']],
            [],
            [],
            "",
            [],
            ["POST"]
        ));

        $routes->add('redis', new Route(
            '/ping',
            ['_controller' => [$this->redisController, 'ping']],
            [],
            [],
            "",
            [],
            ["POST"]
        ));

        return $routes;
    }
}
