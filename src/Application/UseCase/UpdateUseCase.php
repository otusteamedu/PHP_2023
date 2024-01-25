<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\UseCase\Request\UpdateTicketRequest;
use src\Domain\Entity\Ticket;
use src\Domain\Repository\TicketRepositoryContract;

class UpdateUseCase
{
    public function __construct(
        private TicketRepositoryContract $ticketRepository
    )
    {
    }

    public function __invoke(UpdateTicketRequest $request): void
    {
        $this->ticketRepository->update(
            new Ticket(
                id: $request->getId(),
                price: $request->getPrice(),
                showtimeId: $request->getShowtimeId(),
                customerId: $request->getCustomerId(),
                seatInHallId: $request->getSeatInHallId()
            )
        );
    }
}
