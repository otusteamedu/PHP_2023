<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\CarReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'car_report')]
#[ORM\Entity(repositoryClass: CarReportRepository::class)]
class CarReport
{
    #[ORM\Column(name: 'id', type: Types::INTEGER, unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 17, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 17,
        max: 17,
        minMessage: 'VIN номер должен быть длинной 17 символов',
        maxMessage: 'VIN номер должен быть длинной 17 символов'
    )]
    private string $VIN;

    #[ORM\Column(type: Types::STRING, length: 1000, nullable: true)]
    private string $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getVIN(): string
    {
        return $this->VIN;
    }

    public function setVIN(string $VIN): self
    {
        $this->VIN = $VIN;

        return $this;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }
}
