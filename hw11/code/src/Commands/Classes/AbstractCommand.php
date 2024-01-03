<?php

namespace Gkarman\Otuselastic\Commands\Classes;

use Gkarman\Otuselastic\Repositories\ElasticRepository;
use Gkarman\Otuselastic\Repositories\RepositoryInterface;

abstract class AbstractCommand
{
    protected RepositoryInterface $repository;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setRepository();
    }

    /**
     * @throws \Exception
     */
    private function setRepository(): void
    {
        $dirIniFile = 'src/Configs/app.ini';
        $configs = parse_ini_file($dirIniFile);
        $nameRepository = $configs['repository'] ?? '';

        if ($nameRepository === 'elastic') {
            $this->repository = new ElasticRepository();
            return;
        }
        throw new \Exception('Ошибка инициализации репозитория');
    }

    abstract public function run(): string;
}
