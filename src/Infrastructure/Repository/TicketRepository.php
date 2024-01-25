<?php

declare(strict_types=1);

namespace src\Infrastructure\Repository;

use src\Application\Builder\TicketBuilder;
use src\Domain\Entity\Ticket;
use src\Domain\Repository\TicketRepositoryContract;
use src\Infrastructure\DBGateway\Tickets as TicketsDBGateway;

class TicketRepository implements TicketRepositoryContract
{
    private TicketsDBGateway $ticketsDBGateway;
    private TicketBuilder $ticketBuilder;

    public function __construct(
        TicketsDBGateway $ticketsDBGateway,
        TicketBuilder    $ticketBuilder
    )
    {
        //$this->ticketsDBGateway = $ticketsDBGateway;
        $this->ticketBuilder = $ticketBuilder;
        $this->ticketsDBGateway = new TicketsDBGateway(
            new \PDO("pgsql:host=postgreSQL;dbname=postgres", "postgres", "postgres")
        );
    }

    public function getById(int $id): Ticket
    {
        $data = $this->ticketsDBGateway->getById($id);
        return $this->ticketBuilder->fromArray($data);
    }

    public function insert(Ticket $ticket): void
    {
        $this->ticketsDBGateway->insert(
            $ticket->getPrice(),
            $ticket->getShowtimeId(),
            $ticket->getCustomerId(),
            $ticket->getSeatInHallId()
        );
    }

    public function update(Ticket $ticket): void
    {
        $this->ticketsDBGateway->update(
            $ticket->getId(),
            $ticket->getPrice(),
            $ticket->getShowtimeId(),
            $ticket->getCustomerId(),
            $ticket->getSeatInHallId()
        );
    }

    public function delete(int $id): void
    {
        $this->ticketsDBGateway->delete($id);
    }
}
