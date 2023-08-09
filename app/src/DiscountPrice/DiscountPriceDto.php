<?php

declare(strict_types=1);

namespace DEsaulenko\Hw13\DiscountPrice;

class DiscountPriceDto
{
    private int $id;

    private int $product_id;

    private float $discount_price;

    /**
     * @param array $data
     *
     * @return DiscountPriceDto
     */
    public static function fromArray(array $data): DiscountPriceDto
    {
        return new self(
            (int)$data['id'],
            (int)$data['product_id'],
            (float)$data['discount_price'],
        );
    }

    public function __construct(
        int $id,
        int $product_id,
        float $discount_price,
    ) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->discount_price = $discount_price;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'discount_price' => $this->discount_price,
        ];
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
     * @return DiscountPriceDto
     */
    public function setId(int $id): DiscountPriceDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @param int $product_id
     * @return DiscountPriceDto
     */
    public function setProductId(int $product_id): DiscountPriceDto
    {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscountPrice(): float
    {
        return $this->discount_price;
    }

    /**
     * @param float $discount_price
     * @return DiscountPriceDto
     */
    public function setDiscountPrice(float $discount_price): DiscountPriceDto
    {
        $this->discount_price = $discount_price;
        return $this;
    }
}
