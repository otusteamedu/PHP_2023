<?php

declare(strict_types=1);

namespace Dimal\Hw11;

class App
{
    private $useCase;

    public function __construct()
    {
        $this->useCase = 'Dimal\Hw11\Application\UseCase\ConsoleSearchUseCase';
    }

    public function run(array $params): void
    {
        $useCase = new $this->useCase();
        $useCase($params);
    }
}
