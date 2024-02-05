<?php

declare(strict_types=1);

namespace App;

use App\Config\Config;
use App\Config\ConfigInterface;
use App\Http\Request;
use App\Http\RequestInterface;
use App\Router\Router;
use App\Router\RouterInterface;
use App\Storage\RedisStorage;
use App\Storage\StorageInterface;
use App\Validator\Validator;
use App\Validator\ValidatorInterface;

class App
{
    public RequestInterface $request;
    public RouterInterface $router;
    public ConfigInterface $config;
    public StorageInterface $storage;
    public ValidatorInterface $validator;

    public function run(): void
    {
        $this->request = Request::createFromGlobals();

        $this->config = new Config();

        $this->storage = new RedisStorage($this->config);

        $this->validator = new Validator();

        $this->router = new Router($this->request, $this->storage, $this->validator);

        $this->router->dispatch($this->request->uri(), $this->request->method());
    }
}
