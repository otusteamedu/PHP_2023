<?php

namespace Geolocation\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "regions")]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 100, nullable: false)]
    private string $name;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $translations;

    #[ORM\Column(name: 'created_at', type: "datetime", nullable: true)]
    private ?\DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $updatedAt;

    #[ORM\Column(type: "smallint", nullable: false, options: ["default" => 1])]
    private int $flag;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $wikiDataId;

    // Add getter and setter methods for each property

    // ...

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the value of translations
     */
    public function getTranslations(): ?string
    {
        return $this->translations;
    }

    /**
     * Set the value of translations
     */
    public function setTranslations(?string $translations): void
    {
        $this->translations = $translations;
    }

    // Add other getter and setter methods...

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the value of flag
     */
    public function getFlag(): int
    {
        return $this->flag;
    }

    /**
     * Set the value of flag
     */
    public function setFlag(int $flag): void
    {
        $this->flag = $flag;
    }

    /**
     * Get the value of wikiDataId
     */
    public function getWikiDataId(): ?string
    {
        return $this->wikiDataId;
    }

    /**
     * Set the value of wikiDataId
     */
    public function setWikiDataId(?string $wikiDataId): void
    {
        $this->wikiDataId = $wikiDataId;
    }
}
