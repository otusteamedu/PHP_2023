<?php

namespace App\After\Domain\Entity;

use App\After\Domain\Entity\PaidService;
use App\After\Domain\Entity\Project;
use App\After\Domain\Entity\TypeCost;
use App\After\Domain\ValueObject\ProjectCost\Sum;

class ProjectCost
{
    private ?Project $project = null;

    private ?Comment $comment = null;

    private ?Sum $sum = null;

    private ?\DateTimeInterface $date = null;

    private ?\DateTimeImmutable $createdAt = null;

    private ?\DateTimeImmutable $updatedAt = null;

    private ?PaidService $paidService = null;

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPaidService(): ?PaidService
    {
        return $this->paidService;
    }

    public function setPaidService(?PaidService $paidService): static
    {
        $this->paidService = $paidService;

        return $this;
    }
}
