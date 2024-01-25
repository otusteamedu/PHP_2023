<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\UseCase\Request\InsertTicketRequest;
use src\Domain\Entity\Ticket;
use src\Domain\Repository\TicketRepositoryContract;

class InsertUseCase
{
    public function __construct(private TicketRepositoryContract $ticketRepository)
    {
    }

    public function __invoke(InsertTicketRequest $request): void
    {
        $this->ticketRepository->insert(
            new Ticket(
                id: null,
                price: $request->getPrice(),
                showtimeId: $request->getShowtimeId(),
                customerId: $request->getCustomerId(),
                seatInHallId: $request->getSeatInHallId()
            )
        );
    }
}
