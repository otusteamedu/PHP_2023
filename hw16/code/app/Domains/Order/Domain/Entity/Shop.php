<?php

namespace App\Domains\Order\Domain\Entity;

use App\Domains\Order\Domain\ValueObjects\Name;
use App\Domains\Order\Domain\ValueObjects\Price;

class Shop
{
    public function __construct(
        private Name $name,
        private Address $address,
    )
    {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

}
