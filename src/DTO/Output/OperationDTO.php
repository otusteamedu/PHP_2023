<?php
declare(strict_types=1);

namespace App\DTO\Output;

use DateTime;

class OperationDTO
{
    private ?int $id ;
    private string $status;
    private DateTime $startDateTime;
    private ?DateTime $endDateTime;
    private ?string $url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStartDateTime(): DateTime
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(DateTime $startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): ?DateTime
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?DateTime $endDateTime): self
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
