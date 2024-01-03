<?php

namespace Common\Application;

use Common\Infrastructure\AbstractRoute;
use Common\Infrastructure\Route;
use Common\Infrastructure\RouteGroup;
use Exception;
use Psr\Container\ContainerInterface;
use Sunrise\Http\Message\ServerRequestFactory;
use Sunrise\Http\Router\RouteCollector;
use Sunrise\Http\Router\Router;

use function Sunrise\Http\Router\emit;

final readonly class WebApp extends AbstractApp
{
    private Router $router;

    public function __construct(ContainerInterface $container, ConfigInterface $config)
    {
        parent::__construct($container, $config);

        $this->router = new Router();

        $collector = new RouteCollector();
        $collector->setContainer($this->getContainer());
        $this->loadRoutes($collector);
        $this->router->addRoute(...$collector->getCollection()->all());
    }

    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals();
        $response = $this->router->handle($request);

        emit($response);
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @throws Exception
     */
    private function loadRoutes($collector): void
    {
        $arRoutes = require $this->getRootDir() . '/config/routes.php';

        foreach ($arRoutes as $arRoute) {
            $this->addRoute($collector, $arRoute);
        }
    }

    /**
     * @throws Exception
     */
    private function addRoute(RouteCollector $collector, AbstractRoute $route, ?AbstractRoute $parentRoute = null): void
    {
        if ($route instanceof Route) {
            switch ($route->getMethod()) {
                case 'get':
                    $collector->get($route->getName(), $route->getPath(), $route->getHandler());
                    break;
                case 'post':
                    $collector->post($route->getName(), $route->getPath(), $route->getHandler());
                    break;
                case 'put':
                    $collector->put($route->getName(), $route->getPath(), $route->getHandler());
                    break;
                case 'delete':
                    $collector->delete($route->getName(), $route->getPath(), $route->getHandler());
                    break;
                case 'patch':
                    $collector->patch($route->getName(), $route->getPath(), $route->getHandler());
                    break;
                case 'head':
                    $collector->head($route->getName(), $route->getPath(), $route->getHandler());
                    break;
                default:
                    throw new Exception('Unknown method');
            }
        } elseif ($route instanceof RouteGroup) {
            $collector->group(function (RouteCollector $collector) use ($route) {
                foreach ($route->getRoutes() as $route2) {
                    $this->addRoute($collector, $route2, $route);
                }
            });
        } else {
            throw new Exception('Unknown route type');
        }
    }
}
