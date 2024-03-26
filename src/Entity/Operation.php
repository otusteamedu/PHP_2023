<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enums\OperationStatus;
use App\Repository\OperationRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Table(name: 'operation')]
#[ORM\Entity(repositoryClass: OperationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Operation
{
    #[ORM\Column(name: 'id', type: Types::INTEGER, unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, enumType: OperationStatus::class)]
    #[Assert\NotBlank]
    private OperationStatus $status;

    #[ORM\OneToOne(targetEntity: CarReport::class)]
    #[ORM\JoinColumn(name: 'car_report_id', referencedColumnName: 'id')]
    private ?CarReport $carReport = null;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE, nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_MUTABLE, nullable: false)]
    private DateTime $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getStatus(): OperationStatus
    {
        return $this->status;
    }

    public function setStatus(OperationStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCarReport(): ?CarReport
    {
        return $this->carReport;
    }

    public function setCarReport(?CarReport $carReport): self
    {
        $this->carReport = $carReport;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime();

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}
