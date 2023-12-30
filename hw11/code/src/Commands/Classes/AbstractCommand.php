<?php

namespace Gkarman\Otuselastic\Commands\Classes;

use Gkarman\Otuselastic\Elastic\ElasticClient;

abstract class AbstractCommand
{
    protected  $elasticClient;

    public function __construct()
    {
        $this->elasticClient = (new ElasticClient())->init();
    }

    abstract public function run(): string;
}
