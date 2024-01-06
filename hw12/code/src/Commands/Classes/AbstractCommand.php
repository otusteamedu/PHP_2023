<?php

namespace Gkarman\Redis\Commands\Classes;

use Gkarman\Redis\Dto\CommandDto;
use Gkarman\Redis\Repositories\RedisRepository;
use Gkarman\Redis\Repositories\RepositoryInterface;

abstract class AbstractCommand
{
    protected CommandDto $commandDto;
    protected RepositoryInterface $repository;

    /**
     * @throws \Exception
     */
    public function __construct(CommandDto $commandDto)
    {
        $this->commandDto = $commandDto;
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

        if ($nameRepository === 'redis') {
            $this->repository = new RedisRepository();
            return;
        }
        throw new \Exception('Ошибка инициализации репозитория');
    }

    abstract public function run(): string;
}
