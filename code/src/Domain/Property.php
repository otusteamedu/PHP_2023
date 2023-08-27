<?php

declare(strict_types=1);

namespace Art\Php2023\Domain;

class Property
{
    private string $name;
    private string $type;
    private array $cadastralInformation;

    /**
     * @param string $name
     * @param string $type
     * @param array $cadastralInformation
     */
    public function __construct(string $name, string $type, array $cadastralInformation)
    {
        $this->name = $name;
        $this->type = $type;
        $this->cadastralInformation = $cadastralInformation;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getCadastralInformation(): array
    {
        return $this->cadastralInformation;
    }

    /**
     * @param string $name
     * @return Property
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $type
     * @return Property
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }
}
