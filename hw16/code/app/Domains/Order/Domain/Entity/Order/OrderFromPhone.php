<?php

namespace App\Domains\Order\Domain\Entity\Order;

use App\Domains\Order\Domain\ValueObjects\Address;
use App\Domains\Order\Domain\ValueObjects\Phone;
use App\Domains\Order\Domain\ValueObjects\ShopID;

class OrderFromPhone extends AbstractOrder
{
    public function __construct(
        protected ShopID  $shopId,
        protected Phone $phone,
        protected Address $deliveryAddress,
    )
    {
    }
}
