<?php

declare(strict_types=1);

namespace Dimal\Hw11;

use Dimal\Hw11\Application\InputSearchQueryInterface;
use Dimal\Hw11\Application\TableViewInterface;
use Dimal\Hw11\Domain\Repository\BookRepositoryInterface;
use Dimal\Hw11\Infrastructure\ElastickBookRepository;
use Dimal\Hw11\Infrastructure\Console\ConsoleInputSearchQuery;
use Dimal\Hw11\Presentation\ConsoleTableView;

class App
{
    private $useCase;
    private BookRepositoryInterface $boookRepo;
    private TableViewInterface $tableView;
    private InputSearchQueryInterface $inputSearchQuery;

    public function __construct()
    {
        $this->useCase = 'Dimal\Hw11\Application\UseCase\ConsoleSearchUseCase';
        $this->boookRepo = new ElastickBookRepository();
        $this->tableView = new ConsoleTableView();
        $this->inputSearchQuery = new ConsoleInputSearchQuery();
    }

    public function run(array $params): void
    {
        $useCase = new $this->useCase();
        $useCase($this->boookRepo, $this->tableView, $this->inputSearchQuery, $params);
    }
}
