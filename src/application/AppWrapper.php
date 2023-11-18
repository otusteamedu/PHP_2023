<?php

namespace src\application;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use Slim\Factory\AppFactory;
use src\application\configure\ContainerInjections;
use src\application\configure\Middlewares;
use src\application\configure\Routes;

class AppWrapper
{
    private App $app;

    private function __construct()
    {
        $this->setApp(AppFactory::create());
    }

    public static function build(): self
    {
        return new self();
    }

    public static function container(): void
    {
        AppFactory::setContainer(
            ContainerInjections::build()
                ->sets()
                ->getContainer()
        );
    }

    public function middlewares(): self
    {
        $middlewares = new Middlewares();
        $middlewares->add($this->getApp());

        return $this;
    }

    public function routes(): self
    {
        $routes = new Routes();
        $routes->add($this->getApp());

        return $this;
    }

    public function run(): void
    {
        $this->getApp()->run();
    }

    public function getApp(): App
    {
        return $this->app;
    }

    public function setApp(App $app): void
    {
        $this->app = $app;
    }

    public function failResponse(int $code, array $data = []): Response
    {
        $payload = array_merge(['success' => false], $data);

        $response = $this->getApp()->getResponseFactory()->createResponse($code);
        $response->withHeader('Content-type', 'application/json');

        $response->getBody()->write(
            json_encode($payload , JSON_UNESCAPED_UNICODE)
        );

        return $response;
    }
}
