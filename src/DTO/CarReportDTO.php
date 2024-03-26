<?php
declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class CarReportDTO
{
    public const INPUT = 'input';

    private ?int $id = null;

    #[Assert\Length(
        min: 17,
        max: 17,
        minMessage: 'VIN номер должен быть длинной 17 символов',
        maxMessage: 'VIN номер должен быть длинной 17 символов',
        groups: [self::INPUT]
    )]
    #[Assert\NotBlank( groups: [self::INPUT])]
    #[Assert\NotNull(groups: [self::INPUT])]
    #[Groups(self::INPUT)]
    private ?string $VIN;
    private ?string $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getVIN(): ?string
    {
        return $this->VIN;
    }

    public function setVIN(?string $VIN): self
    {
        $this->VIN = $VIN;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }
}
