<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Adapter\ConfigToGetterAdapter;
use App\Application\DTO\ArgumentsDTO;
use App\Application\Helper\RouteAction;
use App\Application\Helper\QueueRepositoryByType;
use App\Application\Helper\StatusRepositoryByType;
use App\Application\Log\Log;
use App\Infrastructure\GetterInterface;
use NdybnovHw03\CnfRead\Storage;

class AppRest
{
    private GetterInterface $cnf;
    private ArgumentsDTO $args;
    private Log $log;

    public function __construct(
        Storage $configStorage,
        array $arguments
    ) {
        $this->cnf = new ConfigToGetterAdapter($configStorage);
        $this->args = new ArgumentsDTO($arguments);
        $this->log = new Log();
    }

    public function run(): void
    {
        $queueRepository = (new QueueRepositoryByType())
            ->get($this->cnf);

        $statusRepository = (new StatusRepositoryByType())
            ->get($this->cnf);

        $respond = ((new RouteAction())->get($this->args))
            ->do($queueRepository, $statusRepository);

        $this->log->useRespond($respond->get(), 201);
    }
}
