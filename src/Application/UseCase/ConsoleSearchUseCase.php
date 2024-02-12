<?php

namespace Dimal\Hw11\Application\UseCase;

use Dimal\Hw11\Application\InputSearchQueryInterface;
use Dimal\Hw11\Application\TableViewInterface;
use Dimal\Hw11\Domain\Entity\Book;
use Dimal\Hw11\Infrastructure\ElastickBookRepository;
use Dimal\Hw11\Infrastructure\Console\ConsoleInputSearchQuery;
use Dimal\Hw11\Presentation\ConsoleTableView;

class ConsoleSearchUseCase
{
    public function __construct()
    {

    }


    public function __invoke($params)
    {
        $bookRepository = new ElastickBookRepository();

        $consoleInputSearchQuery = new ConsoleInputSearchQuery();
        $bookRepository->search($consoleInputSearchQuery($params));

        $consoleTable = new ConsoleTableView();
        $consoleTable->show($bookRepository);
    }


}
