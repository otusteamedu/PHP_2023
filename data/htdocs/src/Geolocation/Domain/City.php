<?php

namespace Geolocation\Domain;

/**
 * @OA\Schema(
 *     title="City",
 *     description="City model",
 * )
 */
class City
{
    /**
     * @var int|null The unique identifier of the city
     * @OA\Property(
     *     type="integer",
     *     description="The unique identifier of the city"
     * )
     */
    private ?int $id;

    /**
     * @var string
     * @OA\Property(
     *      type="string",
     *      description="The name of the city"
     *  )
     */
    private string $name;

    /**
     * @var float The latitude of the city
     * @OA\Property(
     *     type="float",
     *     description="The latitude of the city"
     * )
     */
    private float $latitude;

    /**
     * @var float The longitude of the city
     * @OA\Property(
     *     type="float",
     *     description="The longitude of the city"
     * )
     */
    private float $longitude;

    /**
     * @var \DateTime The date when the city was created
     * @OA\Property(
     *     type="string",
     *     format="date-time",
     *     description="The date when the city was created"
     * )
     */
    private \DateTime $createdAt;

    /**
     * @var \DateTime
     * @OA\Property(
     *     type="string",
     *     format="date-time",
     *     description="The date when the city was updated"
     * )
     */
    private \DateTime $updatedAt;

    /**
     * City constructor.
     * @param int|null $id
     * @param string $name
     * @param float $latitude
     * @param float $longitude
     * @param ?\DateTime $createdAt
     * @param ?\DateTime $updatedAt
     */
    public function __construct(
        ?int $id,
        string $name,
        float $latitude,
        float $longitude,
        ?\DateTime $createdAt = null,
        ?\DateTime $updatedAt = null
    ) {
        $this->id        = $id;
        $this->name      = $name;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;

        if ($createdAt === null) {
            $createdAt = new \DateTime();
        }
        $this->createdAt = $createdAt;

        if ($updatedAt === null) {
            $updatedAt = new \DateTime();
        }
        $this->updatedAt = $updatedAt;
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
     * @return City
     */
    public function setId(?int $id): City
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
     * @return City
     */
    public function setName(string $name): City
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return City
     */
    public function setLatitude(float $latitude): City
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return City
     */
    public function setLongitude(float $longitude): City
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return City
     */
    public function setCreatedAt(\DateTime $createdAt): City
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return City
     */
    public function setUpdatedAt(\DateTime $updatedAt): City
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
