<?php

namespace Sva\Common\App;

use Exception;
use Psr\Container\ContainerInterface;
use Sva\Common\Infrastructure\Http\Router;
use Sva\Singleton;

class App
{
    use Singleton;


    private Router $router;
    private ContainerInterface $container;
    public function __construct()
    {
        $this->createContainer();
        $this->createRouter();
    }

    public function start()
    {
         $this->router->start();
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @return mixed
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @throws Exception
     */
    private function createContainer(): void
    {
        $builder = new \DI\ContainerBuilder();
        $path = realpath(realpath(__DIR__ . '/../../../../di.php'));
        $builder->addDefinitions($path);
        $this->container = $builder->build();
    }

    private function createRouter(): void
    {
        $this->router = new Router();
    }
}
