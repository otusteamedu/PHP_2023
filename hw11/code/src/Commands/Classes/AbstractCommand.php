<?php

namespace Gkarman\Otuselastic\Commands\Classes;

use Gkarman\Otuselastic\Repositories\ElasticRepository;
use Gkarman\Otuselastic\Repositories\RepositoryInterface;

abstract class AbstractCommand
{
    protected RepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = new ElasticRepository();
    }

    abstract public function run(): string;
}
