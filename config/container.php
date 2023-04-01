<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel\Controller;
use Symfony\Component\HttpKernel\EventListener;
use Symfony\Component\Routing;
use Symfony\Component\EventDispatcher;
use Twent\Hw12\App;
use Twent\Hw12\Controllers\EventController;
use Twent\Hw12\ErrorHandler;
use Twent\Hw12\Services\EventManager;

$container = new ContainerBuilder();

$container->register('context', Routing\RequestContext::class);

$container->register('matcher', Routing\Matcher\UrlMatcher::class)
    ->setArguments([$routes, new Reference('context')]);

$container->register('request_stack', HttpFoundation\RequestStack::class);

$container->register('controller_resolver', Controller\ControllerResolver::class);

$container->register('argument_resolver', Controller\ArgumentResolver::class);

$container->register('listener.router', EventListener\RouterListener::class)
    ->setArguments([new Reference('matcher'), new Reference('request_stack')]);

$container->register('listener.response', EventListener\ResponseListener::class)
    ->setArguments(['%charset%']);

$container->register('listener.exception', EventListener\ErrorListener::class)
    ->setArguments([ErrorHandler::class]);

$container->register('dispatcher', EventDispatcher\EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new Reference('listener.response')])
    ->addMethodCall('addSubscriber', [new Reference('listener.exception')]);

$container->register('app', App::class)
    ->setArguments([
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ]);

/**
 * Custom containers register
 */
//$container->register('event_manager', EventManager::class);
//
//$container->register('event_controller', EventController::class)
//    ->setArguments([new Reference('event_manager')]);

return $container;
