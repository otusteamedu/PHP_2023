<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\UseCase\Request\UpdateTicketRequest;
use src\Domain\Repository\TicketRepositoryContract;

class UpdateUseCase
{
    public function __construct(private TicketRepositoryContract $ticketRepository)
    {
    }

    public function __invoke(UpdateTicketRequest $request): void
    {
        $ticket = $this->ticketRepository->getById($request->getId());
        $ticket->setPrice($request->getPrice())
            ->setShowtimeId($request->getShowtimeId())
            ->setCustomerId($request->getCustomerId())
            ->setSeatInHallId($request->getSeatInHallId());

        $this->ticketRepository->update($ticket);
    }
}
