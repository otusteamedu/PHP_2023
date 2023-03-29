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
use Twent\Hw12\ErrorHandler;

$sc = new ContainerBuilder();

$sc->register('context', Routing\RequestContext::class);

$sc->register('matcher', Routing\Matcher\UrlMatcher::class)
    ->setArguments([$routes, new Reference('context')]);

$sc->register('request_stack', HttpFoundation\RequestStack::class);

$sc->register('controller_resolver', Controller\ControllerResolver::class);

$sc->register('argument_resolver', Controller\ArgumentResolver::class);

$sc->register('listener.router', EventListener\RouterListener::class)
    ->setArguments([new Reference('matcher'), new Reference('request_stack')]);

$sc->register('listener.response', EventListener\ResponseListener::class)
    ->setArguments(['%charset%']);

$sc->register('listener.exception', EventListener\ErrorListener::class)
    ->setArguments([ErrorHandler::class]);

$sc->register('dispatcher', EventDispatcher\EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new Reference('listener.response')])
    ->addMethodCall('addSubscriber', [new Reference('listener.exception')]);

$sc->register('app', App::class)
    ->setArguments([
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ]);

return $sc;
