<?php

declare(strict_types=1);

namespace src\Application\UseCase\Request;

class InsertTicketRequest
{
    private float $price;
    private int $showtimeId;
    private int $customerId;
    private int $seatInHallId;

    public function __construct(float $price, int $showtimeId, int $customerId, int $seatInHallId)
    {
        $this->price = $price;
        $this->showtimeId = $showtimeId;
        $this->customerId = $customerId;
        $this->seatInHallId = $seatInHallId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getShowtimeId(): int
    {
        return $this->showtimeId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getSeatInHallId(): int
    {
        return $this->seatInHallId;
    }
}
