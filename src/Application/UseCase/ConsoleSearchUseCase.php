<?php

namespace Dimal\Hw11\Application\UseCase;

use Dimal\Hw11\Infrastructure\ElastickBookRepository;
use Dimal\Hw11\Infrastructure\Console\ConsoleInputSearchQuery;
use Dimal\Hw11\Presentation\ConsoleTableView;

class ConsoleSearchUseCase
{
    public function __invoke($params)
    {
        $consoleInputSearchQuery = new ConsoleInputSearchQuery();

        $bookRepository = new ElastickBookRepository();
        $books = $bookRepository->search($consoleInputSearchQuery($params));

        $consoleTable = new ConsoleTableView();
        $consoleTable->show($books);
    }
}
