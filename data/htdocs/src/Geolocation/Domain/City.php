<?php

namespace Geolocation\Domain;

use Ad\Domain\Ad;
use Ad\Domain\AdFile;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Geolocation\Infrastructure\Repository\CityRepository;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="City",
 *     description="City model",
 * )
 */
#[Entity(repositoryClass: CityRepository::class), Table(name: 'cities')]
class City
{
    /**
     * @var int|null The unique identifier of the city
     * @OA\Property(
     *     type="integer",
     *     description="The unique identifier of the city"
     * )
     */
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The name of the city"
     * )
     */
    #[Column(type: 'string', length: 255)]
    private string $name;

    /**
     * @var int The state id of the city
     * @OA\Property(
     *     type="integer",
     *     description="The state id of the city"
     * )
     */
    #[Column(name: 'state_id', type: 'integer'), JoinColumn(name: 'state_id', referencedColumnName: 'id')]
    private int $stateId;

    /**
     * @var string The state code of the city
     * @OA\Property(
     *     type="string",
     *     description="The state code of the city"
     * )
     */
    #[Column(name: 'state_code', type: 'string', length: 255)]
    private string $stateCode;

    /**
     * @var int The country id of the city
     * @OA\Property(
     *     type="integer",
     *     description="The country id of the city"
     * )
     */
    #[Column(name: 'country_id', type: 'integer'), ManyToOne(targetEntity: Country::class)]
    private int $countryId;

    /**
     * @var string The country code of the city
     * @OA\Property(
     *     type="string",
     *     description="The country code of the city"
     * )
     */
    #[Column(name: 'country_code', type: 'string', length: 2)]
    private string $countryCode;

    /**
     * @var float The latitude of the city
     * @OA\Property(
     *     type="float",
     *     description="The latitude of the city"
     * )
     */
    #[Column(type: 'decimal', precision: 10, scale: 8)]
    private float $latitude;

    /**
     * @var float The longitude of the city
     * @OA\Property(
     *     type="float",
     *     description="The longitude of the city"
     * )
     */
    #[Column(type: 'decimal', precision: 11, scale: 8)]
    private float $longitude;

    /**
     * @var \DateTime The date when the city was created
     * @OA\Property(
     *     type="string",
     *     format="date-time",
     *     description="The date when the city was created"
     * )
     */
    #[Column(name: 'created_at', type: 'datetime')]
    private \DateTime $createdAt;

    /**
     * @var \DateTime
     * @OA\Property(
     *     type="string",
     *     format="date-time",
     *     description="The date when the city was updated"
     * )
     */
    #[Column(name: 'updated_at', type: 'datetime')]
    private \DateTime $updatedAt;

    /**
     * @var int
     * @OA\Property(
     *     type="integer",
     *     description="The flag of the city"
     * )
     */
    #[Column(type: 'smallint')]
    private int $flag;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The wikiDataId of the city"
     * )
     */
    #[Column(name: 'wikiDataId', type: 'string', length: 255, nullable: true)]
    private string $wikiDataId;

    #[OneToMany(mappedBy: 'city', targetEntity: Ad::class, fetch: 'EAGER')]
    private Collection $cities;

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
     * @return int
     */
    public function getStateId(): int
    {
        return $this->stateId;
    }

    /**
     * @param int $stateId
     * @return City
     */
    public function setStateId(int $stateId): City
    {
        $this->stateId = $stateId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStateCode(): string
    {
        return $this->stateCode;
    }

    /**
     * @param string $stateCode
     * @return City
     */
    public function setStateCode(string $stateCode): City
    {
        $this->stateCode = $stateCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     * @return City
     */
    public function setCountryId(int $countryId): City
    {
        $this->countryId = $countryId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return City
     */
    public function setCountryCode(string $countryCode): City
    {
        $this->countryCode = $countryCode;
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

    /**
     * @return int
     */
    public function getFlag(): int
    {
        return $this->flag;
    }

    /**
     * @param int $flag
     * @return City
     */
    public function setFlag(int $flag): City
    {
        $this->flag = $flag;
        return $this;
    }

    /**
     * @return string
     */
    public function getWikiDataId(): string
    {
        return $this->wikiDataId;
    }

    /**
     * @param string $wikiDataId
     * @return City
     */
    public function setWikiDataId(string $wikiDataId): City
    {
        $this->wikiDataId = $wikiDataId;
        return $this;
    }
}