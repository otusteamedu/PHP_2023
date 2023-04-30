<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Infrastructure\Component\Transformer;

use Imitronov\Hw11\Domain\Entity\Product;

final class ProductTransformer
{
    public function __construct(
        private readonly StockTransformer $stockTransformer,
    ) {
    }

    public function transform(array $raw): Product
    {
        return new Product(
            $raw['title'],
            $raw['sku'],
            $raw['category'],
            $raw['price'],
            array_map(
                fn ($stock) => $this->stockTransformer->transform($stock),
                $raw['stock'],
            ),
        );
    }
}
