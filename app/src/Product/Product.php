<?php

declare(strict_types=1);

namespace DEsaulenko\Hw13\Product;

use DEsaulenko\Hw13\DB\Connector;
use DEsaulenko\Hw13\DiscountPrice\DiscountPrice;

class Product
{
    private int $id;

    private string $name;

    private string $description;

    private float $price;

    private string $category;

    private ?float $discountPrice = null;

    public function __construct(
        int $id,
        string $name,
        string $description,
        float $price,
        string $category
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
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
     * @return Product
     */
    public function setId(int $id): Product
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
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getPrice(): float|int
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return Product
     */
    public function setCategory(string $category): Product
    {
        $this->category = $category;
        return $this;
    }

    /**
     * LazyLoad pattern
     *
     * @return float
     */
    public function getDiscountPrice(): float
    {
        if (is_null($this->discountPrice)) {
            $pdo = Connector::getInstance()->getPDO();
            $discountPrice = new DiscountPrice($pdo);
            $this->discountPrice = $discountPrice->findByProductId($this->id)->getDiscountPrice();
            unset($discountPrice);
        }

        return $this->discountPrice;
    }

    /**
     * @param float|null $discountPrice
     * @return $this
     */
    public function setDiscountPrice(float $discountPrice = null): Product
    {
        $this->discountPrice = $discountPrice;
        return $this;
    }
}
