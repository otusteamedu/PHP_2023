<?php

declare(strict_types=1);

namespace Ro\Php2023;

use Predis\Client;
use Ro\Php2023\Controllers\EventsController;
use Ro\Php2023\Controllers\RedisController;
use Ro\Php2023\Routing\RouteConfig;
use Ro\Php2023\Storage\EventStorage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class App
{
    public function run(): void
    {
        $redisClient = new Client([
            'host' => $_ENV['REDIS_HOST'],
            'port' => $_ENV['REDIS_PORT'],
        ]);

        $eventStorage = new EventStorage($redisClient);
        $redisController = new RedisController($redisClient);
        $eventsController = new EventsController($eventStorage);


        $router = new RouteConfig($eventsController, $redisController);

        $routes = $router->configureRoutes();

        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());

        $matcher = new UrlMatcher($routes, $context);

        $resolver = new ControllerResolver();

        $request = Request::createFromGlobals();

        $parameters = $matcher->match($request->getPathInfo());
        $request->attributes->add($parameters);

        $controller = $resolver->getController($request);
        $response = call_user_func($controller, $request);

        $response->send();
    }
}
