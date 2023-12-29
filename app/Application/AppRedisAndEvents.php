<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Helper\EventActionByArgument;
use App\Application\Helper\RepositoryByType;
use App\Application\Log\Log;
use NdybnovHw03\CnfRead\Storage;

class AppRedisAndEvents
{
    private Storage $config;
    private array $arguments;
    private Log $log;

    public function __construct(
        Storage $configStorage,
        array $arguments
    ) {
        $this->config = $configStorage;
        $this->arguments = $arguments;
        $this->log = new Log();
    }

    public function run(): void
    {
        $repository = (new RepositoryByType())
            ->get($this->config);
        $respond = ((new EventActionByArgument())->get($this->arguments))
            ->do($repository);

        $this->log->useRespond($respond->get());
        echo 'Done.' . PHP_EOL;
    }
}
