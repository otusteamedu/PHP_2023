<?php

declare(strict_types=1);

namespace Gesparo\HW\Entity;

class Screening extends BaseEntity
{
    private int $filmId;
    private string $date;
    private string $time;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        int $id,
        int $filmId,
        string $date,
        string $time,
        string $createdAt,
        string $updatedAt
    ) {
        parent::__construct($id);

        $this->filmId = $filmId;
        $this->date = $date;
        $this->time = $time;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getFilmId(): int
    {
        return $this->filmId;
    }

    public function setFilmId(int $filmId): Screening
    {
        $this->filmId = $filmId;
        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): Screening
    {
        $this->date = $date;
        return $this;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function setTime(string $time): Screening
    {
        $this->time = $time;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): Screening
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): Screening
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
