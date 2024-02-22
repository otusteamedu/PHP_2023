<?php

namespace Dimal\Hw11\Application\UseCase;

use Dimal\Hw11\Application\InputSearchQueryInterface;
use Dimal\Hw11\Application\TableViewInterface;
use Dimal\Hw11\Domain\Repository\BookRepositoryInterface;

class ConsoleSearchUseCase
{
    public function __invoke(
        BookRepositoryInterface $bookRepo,
        TableViewInterface $tableView,
        InputSearchQueryInterface $consoleInputSearchQuery,
        array $params
    ) {
        $tableView->show($bookRepo->search($consoleInputSearchQuery($params)));
    }
}
