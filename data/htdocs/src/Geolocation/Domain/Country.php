<?php

namespace Geolocation\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: "countries")]
class Country
{
    #[Id, GeneratedValue(strategy: "AUTO"), Column(type: "integer")]
    private ?int $id;

    #[Column(type: "string", length: 100, nullable: false)]
    private string $name;

    #[Column(type: "string", length: 3, nullable: true)]
    private string $iso3;

    #[Column(name: 'numeric_code', type: "string", length: 3, nullable: true)]
    private string $numericCode;

    #[Column(type: "string", length: 2, nullable: true)]
    private string $iso2;

    #[Column(type: "string", length: 255, nullable: true)]
    private string $phonecode;

    #[Column(type: "string", length: 255, nullable: true)]
    private string $capital;

    #[Column(type: "string", length: 255, nullable: true)]
    private string $currency;

    #[Column(name: 'currency_name', type: "string", length: 255, nullable: true)]
    private string $currencyName;

    #[Column(name: 'currency_symbol', type: "string", length: 255, nullable: true)]
    private string $currencySymbol;

    #[Column(type: "string", length: 255, nullable: true)]
    private string $tld;

    #[Column(type: "string", length: 255, nullable: true)]
    private string $native;

    #[Column(type: "string", length: 255, nullable: true)]
    private string $region;

    #[Column(name: 'region_id', type: "integer", nullable: true)]
    private int $regionId;

    #[ManyToOne(targetEntity: Region::class), JoinColumn(name: "region_id", referencedColumnName: "id")]
    private Region $regionEntity;

    #[Column(type: "string", length: 255, nullable: true)]
    private string $subregion;

    #[Column(type: "integer", nullable: true)]
    private int $subregionId;

    #[Column(type: "string", length: 255, nullable: true)]
    private string $nationality;

    #[Column(type: "text", nullable: true)]
    private string $timezones;

    #[Column(type: "text", nullable: true)]
    private string $translations;

    #[Column(type: "decimal", precision: 10, scale: 8, nullable: true)]
    private float $latitude;

    #[Column(type: "decimal", precision: 11, scale: 8, nullable: true)]
    private float $longitude;

    #[Column(type: "string", length: 191, nullable: true)]
    private string $emoji;

    #[Column(name: 'emojiU', type: "string", length: 191, nullable: true)]
    private string $emojiU;

    #[Column(name: 'created_at', type: "datetime", nullable: true)]
    private \DateTime $createdAt;

    #[Column(name: 'updated_at', type: "datetime", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $updatedAt;

    #[Column(type: "smallint", nullable: false, options: ["default" => 1])]
    private int $flag;

    #[Column(type: "string", length: 255, nullable: true)]
    private string $wikiDataId;

    #[ManyToOne(targetEntity: Subregion::class), JoinColumn(name: "subregion_id", referencedColumnName: "id")]
    private Subregion $subregionEntity;
}
