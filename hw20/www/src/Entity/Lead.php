<?php

namespace Shabanov\Otusphp\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'leads')]
class Lead
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    public int $id;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: 'Name is required')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Name cannot be longer than {{ limit }} characters', maxMessage: 'Name cannot be longer than {{ limit }} characters')]
    public string $name;

    #[ORM\Column(type: 'string', unique: true)]
    #[Assert\NotBlank(message: 'Email is required')]
    #[Assert\Email(message: 'Invalid email address')]
    public string $email;

    #[ORM\Column(type: 'string', unique: true)]
    #[Assert\Uuid(message: 'Not uuid')]
    public string $uuid;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid = null): self
    {
        $this->uuid = $uuid;
        return $this;
    }
}
