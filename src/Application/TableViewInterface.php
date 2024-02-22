<?php

namespace Dimal\Hw11\Application;

use Dimal\Hw11\Domain\Repository\BookRepositoryInterface;

interface TableViewInterface
{
    public function show(array $books): void;
}
