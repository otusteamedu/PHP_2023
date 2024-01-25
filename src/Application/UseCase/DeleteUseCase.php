<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Domain\Repository\TicketRepositoryContract;

class DeleteUseCase
{
    public function __construct(private TicketRepositoryContract $ticketRepository)
    {
    }

    public function __invoke(int $id): void
    {
        $this->ticketRepository->delete($id);
    }
}
