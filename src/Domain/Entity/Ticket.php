<?php

declare(strict_types=1);

namespace src\Domain\Entity;

class Ticket
{
    private ?int $id;
    private float $price;
    private int $showtimeId;
    private int $customerId;
    private int $seatInHallId;

    public function __construct(?int $id, float $price, int $showtimeId, int $customerId, int $seatInHallId)
    {
        $this->id = $id;
        $this->price = $price;
        $this->showtimeId = $showtimeId;
        $this->customerId = $customerId;
        $this->seatInHallId = $seatInHallId;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setPrice(?float $price): Ticket
    {
        if ($price === null) {
            return $this;
        }
        $this->price = $price;
        return $this;
    }

    public function setShowtimeId(?int $showtimeId): Ticket
    {
        if ($showtimeId === null) {
            return $this;
        }
        $this->showtimeId = $showtimeId;
        return $this;
    }

    public function setCustomerId(?int $customerId): Ticket
    {
        if ($customerId === null) {
            return $this;
        }
        $this->customerId = $customerId;
        return $this;
    }

    public function setSeatInHallId(?int $seatInHallId): Ticket
    {
        if ($seatInHallId === null) {
            return $this;
        }
        $this->seatInHallId = $seatInHallId;
        return $this;
    }
}
