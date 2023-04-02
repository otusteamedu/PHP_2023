<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;
use Symfony\Component\EventDispatcher;
use Twent\Hw12\App;
use Twent\Hw12\ErrorHandler;
use Twent\Hw12\Services\EventManager;

/**
 * @var $container DependencyInjection\ContainerBuilder
 */
$routes = include $container->getParameter('routes');

$container->register('context', Routing\RequestContext::class);

$container->register('matcher', Routing\Matcher\UrlMatcher::class)
    ->setArguments([$routes, new DependencyInjection\Reference('context')]);

$container->register('request_stack', HttpFoundation\RequestStack::class);

$container->register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);

$container->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);

$container->register('listener.router', HttpKernel\EventListener\RouterListener::class)
    ->setArguments([new DependencyInjection\Reference('matcher'), new DependencyInjection\Reference('request_stack')]);

$container->register('listener.response', HttpKernel\EventListener\ResponseListener::class)
    ->setArguments(['%charset%']);

$container->register('listener.exception', HttpKernel\EventListener\ErrorListener::class)
    ->setArguments([ErrorHandler::class]);

$container->register('dispatcher', EventDispatcher\EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new DependencyInjection\Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new DependencyInjection\Reference('listener.response')])
    ->addMethodCall('addSubscriber', [new DependencyInjection\Reference('listener.exception')]);

$container->register('app', App::class)
    ->setArguments([
        new DependencyInjection\Reference('dispatcher'),
        new DependencyInjection\Reference('controller_resolver'),
        new DependencyInjection\Reference('request_stack'),
        new DependencyInjection\Reference('argument_resolver'),
    ]);

$container->register('cache_store', HttpKernel\HttpCache\Store::class)
    ->setArguments(['%cache_dir%']);

$container->register('esi', HttpKernel\HttpCache\Esi::class);

$container->register('cached_app', HttpKernel\HttpCache\HttpCache::class)
    ->setArguments([
        new DependencyInjection\Reference('app'),
        new DependencyInjection\Reference('cache_store'),
        new DependencyInjection\Reference('esi'),
        ['debug' => '%debug%'],
    ]);

/**
 * Custom containers register
 */
$container->register('event_manager', EventManager::class);
