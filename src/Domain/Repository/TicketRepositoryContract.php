<?php

declare(strict_types=1);

namespace src\Domain\Repository;

use src\Domain\Entity\Ticket;

interface TicketRepositoryContract
{
    public function getById(int $id): Ticket;

    public function insert(Ticket $ticket): void;

    public function update(Ticket $ticket): void;

    public function delete(int $id): void;
}
