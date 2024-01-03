<?php

namespace Geolocation\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "states")]
class State
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'country_id', type: "integer", nullable: false)]
    private int $countryId;

    #[ORM\Column(name: 'country_code', type: "string", length: 2, nullable: false)]
    private string $countryCode;

    #[ORM\Column(name: 'fips_code', type: "string", length: 255, nullable: true)]
    private ?string $fipsCode;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $iso2;

    #[ORM\Column(type: "string", length: 191, nullable: true)]
    private ?string $type;

    #[ORM\Column(type: "decimal", precision: 10, scale: 8, nullable: true)]
    private ?float $latitude;

    #[ORM\Column(type: "decimal", precision: 11, scale: 8, nullable: true)]
    private ?float $longitude;

    #[ORM\Column(name: 'created_at', type: "datetime", nullable: true)]
    private ?\DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: "datetime", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $updatedAt;

    #[ORM\Column(type: "smallint", nullable: false, options: ["default" => 1])]
    private int $flag;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $wikiDataId;

    #[ORM\ManyToOne(targetEntity: "Country")]
    #[ORM\JoinColumn(name: "country_id", referencedColumnName: "id")]
    private ?Country $countryEntity;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return State
     */
    public function setId(?int $id): State
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
     * @return State
     */
    public function setName(string $name): State
    {
        $this->name = $name;
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
     * @return State
     */
    public function setCountryId(int $countryId): State
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
     * @return State
     */
    public function setCountryCode(string $countryCode): State
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFipsCode(): ?string
    {
        return $this->fipsCode;
    }

    /**
     * @param string|null $fipsCode
     * @return State
     */
    public function setFipsCode(?string $fipsCode): State
    {
        $this->fipsCode = $fipsCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIso2(): ?string
    {
        return $this->iso2;
    }

    /**
     * @param string|null $iso2
     * @return State
     */
    public function setIso2(?string $iso2): State
    {
        $this->iso2 = $iso2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return State
     */
    public function setType(?string $type): State
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     * @return State
     */
    public function setLatitude(?float $latitude): State
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     * @return State
     */
    public function setLongitude(?float $longitude): State
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     * @return State
     */
    public function setCreatedAt(?\DateTime $createdAt): State
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
     * @return State
     */
    public function setUpdatedAt(\DateTime $updatedAt): State
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
     * @return State
     */
    public function setFlag(int $flag): State
    {
        $this->flag = $flag;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWikiDataId(): ?string
    {
        return $this->wikiDataId;
    }

    /**
     * @param string|null $wikiDataId
     * @return State
     */
    public function setWikiDataId(?string $wikiDataId): State
    {
        $this->wikiDataId = $wikiDataId;
        return $this;
    }

    /**
     * @return Country|null
     */
    public function getCountryEntity(): ?Country
    {
        return $this->countryEntity;
    }

    /**
     * @param Country|null $countryEntity
     * @return State
     */
    public function setCountryEntity(?Country $countryEntity): State
    {
        $this->countryEntity = $countryEntity;
        return $this;
    }
}