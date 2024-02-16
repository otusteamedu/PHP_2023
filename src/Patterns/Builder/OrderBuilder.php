<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\Builder;

use Exception;
use Patterns\Daniel\Products\ProductInterface;

class OrderBuilder implements OrderBuilderInterface
{
    private array $products = [];

    public function addProduct(ProductInterface $product): OrderBuilderInterface
    {
        $this->products[] = [
            'product' => $product,
            'ingredients' => []
        ];

        return $this;
    }

    /**
     * @throws Exception
     */
    public function addIngredient(string $ingredient): OrderBuilderInterface
    {
        if (empty($this->products)) {
            throw new Exception("You can't add an ingredient without a product.");
        }

        $lastProductKey = array_key_last($this->products);
        $this->products[$lastProductKey]['ingredients'][] = $ingredient;

        return $this;
    }

    public function getOrder(): array
    {
        return $this->products;
    }
}