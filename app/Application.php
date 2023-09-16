<?php

namespace Rofflexor\Hw;
use Laminas\Diactoros\Response\HtmlResponse;
use MiladRahimi\PhpContainer\Container;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Router;
use Rofflexor\Hw\Helpers\FileHelper;
use Throwable;

class Application
{

    public function run(): void
    {
        $router = Router::create();
        $routes = FileHelper::getDirContents(__DIR__.'/Routes/');
        if(!empty($routes)) {
            foreach ($routes as $route) {
                require_once $route;
            }
            try {
                $router->dispatch();
            } catch (RouteNotFoundException $e) {
                $router->getPublisher()->publish(new HtmlResponse('Not found.', 404));
            } catch (Throwable $e) {
                echo $e->getMessage();
                $router->getPublisher()->publish(new HtmlResponse('Internal error.', 500));
            }
        }

    }

}