<?php

namespace App\Entity;

use App\Entity\Builder\ContractBuilder;
use App\Repository\ContractRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $header = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $preamble = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $signature = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(ContractBuilder $contractBuilder)
    {
        $this->header = $contractBuilder->getHeader();
        $this->preamble = $contractBuilder->getPreamble();
        $this->text = $contractBuilder->getText();
        $this->signature = $contractBuilder->getSignature();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }
}
