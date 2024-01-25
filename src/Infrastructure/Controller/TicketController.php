<?php

declare(strict_types=1);

namespace src\Infrastructure\Controller;

use src\Application\Builder\TicketBuilder;
use src\Application\UseCase\DeleteUseCase;
use src\Application\UseCase\GetByIdUseCase;
use src\Application\UseCase\InsertUseCase;
use src\Application\UseCase\Request\InsertTicketRequest;
use src\Application\UseCase\Request\UpdateTicketRequest;
use src\Application\UseCase\Response\GetByIdTicketResponse;
use src\Application\UseCase\UpdateUseCase;
use src\Infrastructure\DBGateway\Tickets as TicketsDBGateway;
use src\Infrastructure\Repository\TicketRepository;

class TicketController
{
    public function create(array $argv): void
    {
        $insertUseCase = new InsertUseCase(
            new TicketRepository(
                new TicketsDBGateway(
                    new \PDO("pgsql:host=postgreSQL;dbname=postgres", "postgres", "postgres")
                ),
                new TicketBuilder()
            )
        );

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
        $getByIdUseCase = new GetByIdUseCase(
            new TicketRepository(
                new TicketsDBGateway(
                    new \PDO("pgsql:host=postgreSQL;dbname=postgres", "postgres", "postgres")
                ),
                new TicketBuilder()
            )
        );

        var_dump($getByIdUseCase((int)$argv[2]));
    }

    public function update(array $argv): void
    {
        $updateUseCase = new UpdateUseCase(
            new TicketRepository(
                new TicketsDBGateway(
                    new \PDO("pgsql:host=postgreSQL;dbname=postgres", "postgres", "postgres")
                ),
                new TicketBuilder()
            )
        );

        $updateUseCase(
            new UpdateTicketRequest(
                id: (int)$argv[2],
                price: (float)$argv[3],
                showtimeId: (int)$argv[4],
                customerId: (int)$argv[5],
                seatInHallId: (int)$argv[6]
            )
        );
    }

    public function delete(array $argv): void
    {
        $deleteUseCase = new DeleteUseCase(
            new TicketRepository(
                new TicketsDBGateway(
                    new \PDO("pgsql:host=postgreSQL;dbname=postgres", "postgres", "postgres")
                ),
                new TicketBuilder()
            )
        );

        $deleteUseCase((int)$argv[2]);
    }
}
