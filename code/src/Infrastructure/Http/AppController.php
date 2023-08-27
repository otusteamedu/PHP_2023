<?php

declare(strict_types=1);

namespace Art\Php2023\Infrastructure\Http;

use Art\Php2023\Application\UseCase\DocumentUseCase;
use Art\Php2023\Infrastructure\Exception\MethodNotFoundException;
use Art\Php2023\Infrastructure\Exception\NotAllowedException;
use Art\Php2023\Infrastructure\Repository\PropertyRepository;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

final class AppController
{
    /**
     * @throws MethodNotFoundException
     * @throws NotAllowedException
     */
    private function execute()
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->addRoute('POST', '/property/{name}/{type}', PropertyRepository::class . '/insert');
            $r->addRoute('GET', '/property/', PropertyRepository::class . '/findAll');
            $r->addRoute('GET', '/property/{id:\d+}/{needCadastralInfo}', PropertyRepository::class . '/getById');
            $r->addRoute('GET', '/property/make-rent-package-documents/{type}', DocumentUseCase::class . '/makePackageDocumentsByType');
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:

                return throw new MethodNotFoundException("Such a uri - \"$uri\" not match method");
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];

                return throw new NotAllowedException('405 Method Not Allowed - ' . $allowedMethods);
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                list($class, $method) = explode("/", $handler, 2);

                call_user_func_array(array(new $class, $method), $vars);
                break;
        }
    }

    /**
     * @throws MethodNotFoundException
     * @throws NotAllowedException
     */
    public function run(): void
    {
        $this->execute();
    }
}
