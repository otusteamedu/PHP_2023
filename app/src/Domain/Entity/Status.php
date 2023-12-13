<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Name;

class Status
{
    /** @var string  */
    public const DONE = 'Done';

    /** @var string  */
    public const IN_WORK = 'In work';

    private Name $name;

    private ?int $id = null;

    public function __construct(Name $name)
    {
        $this->name = $name;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
