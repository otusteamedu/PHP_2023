<?php

declare(strict_types=1);

namespace Root\App\HotDog;

use Root\App\Product;

class HotDogAdapter extends Product
{
    protected HotDog $product;

    public function __construct(int $lettuce, int $onion, int $pepper)
    {
        $this->product = new HotDog($lettuce, $onion);
        parent::__construct(0, 0, 0);
    }

    public function getLettuce(): int
    {
        return $this->product->getSauce();
    }
    public function getOnion(): int
    {
        return $this->product->getMustard();
    }
    public function getPepper(): int
    {
        return 0;
    }

    public function getName(): string
    {
        return $this->product->getName();
    }
}
