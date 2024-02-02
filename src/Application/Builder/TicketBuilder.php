<?php

declare(strict_types=1);

namespace src\Application\Builder;

use src\Domain\Entity\Ticket;

class TicketBuilder
{
    public function fromArray(array $data): Ticket
    {
        return new Ticket(
            $data['id'],
            (float)$data['price'],
            $data['showtime_id'],
            $data['customer_id'],
            $data['seat_in_hall_id']
        );
    }
}
