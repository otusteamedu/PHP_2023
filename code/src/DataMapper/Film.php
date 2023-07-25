<?php

declare(strict_types = 1);

namespace VKorabelnikov\Hw13\DataMapper;

class Film
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
     * @var string
     */
    private $duration;

    /**
     * @var float
     */
    private $cost;


    /**
     * @param int $id
     * @param string $name
     * @param string $duration
     * @param float $cost
     */
    public function __construct(
        int $id,
        string $name,
        string $duration,
        float $cost
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;
        $this->cost = $cost;
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
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     * @return self
     */
    public function setDuration(string $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     * @return self
     */
    public function setCost(float $cost): self
    {
        $this->cost = $cost;
        return $this;
    }
}
