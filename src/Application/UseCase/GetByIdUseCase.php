<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\UseCase\Response\GetByIdTicketResponse;
use src\Domain\Repository\TicketRepositoryContract;

class GetByIdUseCase
{
    public function __construct(
        private TicketRepositoryContract $ticketRepository
    )
    {
    }

    public function __invoke(int $id): GetByIdTicketResponse
    {
        $ticket = $this->ticketRepository->getById($id);
        return new GetByIdTicketResponse(
            id: $ticket->getId(),
            price: $ticket->getPrice(),
            showtimeId: $ticket->getShowtimeId(),
            customerId: $ticket->getCustomerId(),
            seatInHallId: $ticket->getSeatInHallId()
        );
    }
}
