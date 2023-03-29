<?php

declare(strict_types=1);

namespace Tests\Feature;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Tests\TestCase;
use Twent\Hw12\App;
use Twent\Hw12\Controllers\EventController;

final class AppTest extends TestCase
{

    public function testNotFoundHandling()
    {
        dd($this->get('/'));
        //$app = $this->getAppForException(new ResourceNotFoundException());

        //$response = $app->handle(new Request('/not-found'));

        //$this->assertEquals(404, $response->getStatusCode());
    }

    public function testErrorHandling()
    {
//        $app = $this->getAppForException(new \RuntimeException());
//
//        $response = $app->handle(new Request());
//
//        $this->assertEquals(500, $response->getStatusCode());
    }

    private function getAppForException($exception): App
    {
        $matcher = $this->createMock(UrlMatcherInterface::class);

        $matcher
            ->expects($this->once())
            ->method('match')
            ->will($this->throwException($exception));

        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($this->createMock(RequestContext::class)));

        $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        $argumentResolver = $this->createMock(ArgumentResolverInterface::class);

        return new App($matcher, $controllerResolver, $argumentResolver);
    }

    public function testControllerResponse()
    {
        $routes = (new RouteCollection())->add(
            'event_list',
            new Route('/', ['_controller' => [EventController::class, 'index']]));

        $app = new App($routes);

        $response = $sc->get('app')->handle(new Request('/'));

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringContainsString('data', $response->getContent());
    }
}
