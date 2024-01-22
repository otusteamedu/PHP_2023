<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\DataMapper;

class ProductCollection
{
    private array $products;
    public function __construct(?array $arProducts = [])
    {
        $this->products = $arProducts;
    }

    public function add(Product $product): self
    {
        $this->products[] = $product;
        return $this;
    }

    public function getAll(): array
    {
        return $this->products;
    }

    public function delete(Product $product): bool
    {
        if (!empty($this->products)) {
            foreach($this->products as $k=>$prod) {
                if ($product->getId() == $prod->getId()) {
                    unset($this->products[$k]);
                    return true;
                }
            }
        }
        return false;
    }
}
