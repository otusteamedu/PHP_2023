<?php

namespace App\Domains\Order\Domain\Entity\Order;

use App\Domains\Order\Domain\ValueObjects\Address;
use App\Domains\Order\Domain\ValueObjects\Email;
use App\Domains\Order\Domain\ValueObjects\ShopID;

class OrderFromSite extends AbstractOrder
{
    public function __construct(
        protected ShopID  $shopId,
        protected Email $email,
        protected Address $deliveryAddress,
    )
    {
    }
}
