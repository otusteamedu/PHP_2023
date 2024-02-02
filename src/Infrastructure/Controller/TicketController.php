<?php

declare(strict_types=1);

namespace src\Infrastructure\Controller;

use src\Application\Builder\TicketBuilder;
use src\Application\UseCase\DeleteUseCase;
use src\Application\UseCase\GetByIdUseCase;
use src\Application\UseCase\InsertUseCase;
use src\Application\UseCase\Request\InsertTicketRequest;
use src\Application\UseCase\Request\UpdateTicketRequest;
use src\Application\UseCase\UpdateUseCase;
use src\Domain\Repository\TicketRepositoryContract;
use src\Infrastructure\DBGateway\Tickets as TicketsDBGateway;
use src\Infrastructure\Repository\TicketRepository;

class TicketController
{
    private TicketRepositoryContract $ticketRepository;

    public function __construct()
    {
        $env = parse_ini_file(__DIR__ . '/../../../.env');

        $dbHost = $env['DB_HOST'];
        $dbName = $env['DB_DATABASE'];
        $dbUserName = $env['DB_USERNAME'];
        $dbPassword = $env['DB_PASSWORD'];

        $this->ticketRepository = new TicketRepository(
            new TicketsDBGateway(
                new \PDO(
                    dsn: "pgsql:host=$dbHost;dbname=$dbName",
                    username: $dbUserName,
                    password: $dbPassword
                )
            ),
            new TicketBuilder()
        );
    }

    public function create(array $argv): void
    {
        $insertUseCase = new InsertUseCase($this->ticketRepository);

        $insertUseCase(
            new InsertTicketRequest(
                price: (float)$argv[2],
                showtimeId: (int)$argv[3],
                customerId: (int)$argv[4],
                seatInHallId: (int)$argv[5]
            )
        );
    }

    public function get(array $argv): void
    {
        $getByIdUseCase = new GetByIdUseCase($this->ticketRepository);

        var_dump($getByIdUseCase((int)$argv[2]));
    }

    public function update(array $argv): void
    {
        $updateUseCase = new UpdateUseCase($this->ticketRepository);

        $updateUseCase(
            new UpdateTicketRequest(
                id: (int)$argv[2],
                price: isset($argv[3]) ? (float)$argv[3] : null,
                showtimeId: isset($argv[4]) ? (int)$argv[4] : null,
                customerId: isset($argv[5]) ? (int)$argv[5] : null,
                seatInHallId: isset($argv[6]) ? (int)$argv[6] : null
            )
        );
    }

    public function delete(array $argv): void
    {
        $deleteUseCase = new DeleteUseCase($this->ticketRepository);

        $deleteUseCase((int)$argv[2]);
    }
}
