<?php

namespace Sva\Common\App;

use Exception;
use Psr\Container\ContainerInterface;
use Sva\Common\Infrastructure\Cli\Commander;
use Sva\Common\Infrastructure\Http\Router;
use Sva\Singleton;

class App
{
    use Singleton;

    private Router $router;
    private ContainerInterface $container;
    /**
     * @var null
     */
    private Commander $commander;

    public function __construct()
    {
        $this->createContainer();
        $this->createCommander();
    }

    public function start(array $args = [])
    {
        $this->commander->start($args);
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

    public function createCommander(): void
    {
        $this->commander = (new Commander());
        $path = realpath(realpath(__DIR__ . '/../../../../commandes.php'));
        $this->commander->loadCommands($path);
    }

    public function getDocumentRoot(): string
    {
        return __DIR__ . '/../../../../';
    }
}
