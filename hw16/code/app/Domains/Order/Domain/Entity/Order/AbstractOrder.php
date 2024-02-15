<?php

namespace App\Domains\Order\Domain\Entity\Order;

use App\Domains\Order\Domain\Entity\Product\Product;
use App\Domains\Order\Domain\ValueObjects\ShopID;

class AbstractOrder
{
    protected ?int $id = null;
    protected ShopID $shopId;
    protected array $products;

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
