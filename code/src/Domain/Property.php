<?php

declare(strict_types=1);

namespace Art\Php2023\Domain;

class Property
{
    public ?int $id;
    private ?string $name;
    private ?string $type;
    private ?array $cadastralInformation;

    /**
     * @param int|null $id
     * @param string|null $name
     * @param string|null $type
     * @param array|null $cadastralInformation
     */
    public function __construct(?int $id = null, ?string $name = null, ?string $type = null, ?array $cadastralInformation = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->cadastralInformation = $cadastralInformation;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return array|null
     */
    public function getCadastralInformation(): ?array
    {
        return $this->cadastralInformation;
    }

    /**
     * @param int|null $id
     * @return Property
     */
    public function setId(int|null $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string|null $name
     * @return Property
     */
    public function setName(string|null $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string|null $type
     * @return Property
     */
    public function setType(string|null $type): self
    {
        $this->type = $type;
        return $this;
    }
}