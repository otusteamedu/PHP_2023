<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\DTO\AddArgumentsDTO;
use App\Application\DTO\ArgumentsDTO;
use App\Application\Helper\RouteAction;
use App\Application\Helper\RepositoryByType;
use App\Application\Log\Log;
use NdybnovHw03\CnfRead\Storage;

class AppQueue
{
    private Storage $config;
    private array $args;
    private Log $log;

    public function __construct(
        Storage $configStorage,
        array $arguments
    ) {
        $this->config = $configStorage;
        $this->args = $arguments;
        $this->log = new Log();
    }

    public function run(): void
    {
        $args = new ArgumentsDTO($this->args);

        $repository = (new RepositoryByType())
            ->get($this->config);
        $respond = ((new RouteAction())->get($args))
            ->do($repository);

        $this->log->useRespond($respond->get(), 201);
    }
}
