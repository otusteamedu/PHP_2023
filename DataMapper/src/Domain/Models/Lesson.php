<?php

declare(strict_types=1);

namespace Art\DataMapper\Domain\Models;

class Lesson
{
    public ?int $id;

    private ?string $name;

    /**
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(?int $id = null, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Lesson
     */
    public function setId(int|null $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Lesson
     */
    public function setName(string|null $name): self
    {
        $this->name = $name;
        return $this;
    }
}