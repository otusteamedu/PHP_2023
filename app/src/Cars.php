<?php

declare(strict_types=1);

namespace App;

class Cars
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $models;

    /**
     * @var callable
     */
    private $reference;

     /**
     * @param int $id
     * @param string $name
     */
    public function __construct(
        int $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

     /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getModels(): array
    {
        $reference = $this->reference;
        return $reference();
    }

    /**
     * @param string $name
     * @return self
     */
    public function setReference(callable $reference): self
    {
        $this->reference = $reference;
        return $this;
    }
}
